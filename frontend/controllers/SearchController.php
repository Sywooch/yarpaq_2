<?php

namespace frontend\controllers;

use common\components\ProductSearch;
use common\models\Manufacturer;
use frontend\models\ProductFilter;
use frontend\models\ProductRepository;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use frontend\components\CustomLinkPager;
use common\models\Product;
use common\models\category\Category;
use common\models\search\SearchLogger;
use yii\helpers\ArrayHelper;
use yii\web\Response;


class SearchController extends BasicController
{

    public $freeAccessActions = ['index', 'elastic', 'auto'];

    public function actionElastic() {
        $request        = Yii::$app->request;
        $productFilter  = $this->initFilter();
        $query          = $this->initQuery();
        $page           = $request->get('page') ? (int) $request->get('page') : 1;
        $elastic = new ProductSearch();


        // pagination
        $total = $elastic->total($query, $productFilter);

        $pagination = new Pagination([
            'totalCount' => $total,
            'defaultPageSize' => $productFilter->per_page ? $productFilter->per_page : 24,
            'page' => $page
        ]);

        $response = $elastic->search($query, $productFilter, $pagination->page, $pagination->limit);

        $elasticIDs = [];
        foreach ($response['hits']['hits'] as $hit) {
            $elasticIDs[] = $hit['_id'];
        }

        $products = Product::find()->andWhere(['in', 'id', $elasticIDs]);

        $minMaxPrice    = $elastic->minMaxPrice($query, $productFilter);
        $productFilter->price_min = floor($minMaxPrice['aggregations']['min_price']['value']);
        $productFilter->price_max = ceil($minMaxPrice['aggregations']['max_price']['value']);


        $raw_models = ArrayHelper::map($products->all(), 'id', function ($model) {
            return $model;
        });

        $models = [];
        foreach ($elasticIDs as $elasticID) {
            $models[$elasticID] = $raw_models[$elasticID];
        }
        // GET Products END

        // GET Brands
        $elasticBrands = $elastic->getBrands($query);
        $brands = [];
        if (count($elasticBrands)) {
            $brands = Manufacturer::find()
                ->andWhere(['in', 'id', $elastic->getBrands($query)])
                ->all();
        }
        // GET Brands END


        $this->view->params['q'] = $query;

        $this->seo(Yii::t('app', 'Search'));

        return $this->render('index', [
            'count'             => $pagination->totalCount,
            'search_q'          => $query,
            'products'          => $models,
            'pages'             => $pagination,
            'pagination'        => CustomLinkPager::widget([ 'pagination' => $pagination ]),
            'filterBrands'      => $brands,
            'productFilter'     => $productFilter,
        ]);
    }

    protected function initFilter() {
        $productFilter = new ProductFilter();
        $productFilter->load(Yii::$app->request->get());

        if (!$productFilter->validate()) {
            throw new Exception('Wrong filter');
        }

        return $productFilter;
    }

    protected function initQuery() {
        $query = '';
        $r = Yii::$app->request;
        if ($r->get('q') && $r->get('q') != '') {
            $query = htmlspecialchars(strip_tags($r->get('q')), ENT_QUOTES, 'UTF-8');

            SearchLogger::log($query);
        }

        return $query;
    }

    public function actionIndex() {
        $r = Yii::$app->request;

        $q = '';
        $category = null;
        $childrenCategoriesIDs = [];
        $page = $r->get('page') ? (int) $r->get('page') : 1;

        // Параметры фильтра
        $productFilter = new ProductFilter();
        $productFilter->load($r->get());

        if (!$productFilter->validate()) {
            throw new Exception('Wrong filter');
        }

        // GET Products

        if ($r->get('q') && $r->get('q') != '') {
            $q = htmlspecialchars(strip_tags($r->get('q')), ENT_QUOTES, 'UTF-8');

            SearchLogger::log($q);
        } else {
            return $this->render('notfound');
        }

        $repo = new ProductRepository();
        $products = $repo->visibleOnTheSite();

        $title_cond = ['or'];
        $title_cond[] = ['like', 'title', $q];

        $q_parts = explode(' ', $q);
        foreach ($q_parts as $q_part) {
            $title_cond[] = ['like', 'title', $q_part];
        }

        $title_cond[] = ['id' => $q];
        $products->andWhere($title_cond);

//        $detailed_products = clone $products;
//        foreach ($q_parts as $q_part) {
//            $detailed_products->orWhere(['like', 'title', $q_part]);
//        }
//        $products->union($detailed_products);


        // если указана категория, то находим все ее дочерние и ищем по этим категориям
        if ($r->get('category_id')) {
            $category_id = $r->get('category_id');

            // Поиск среди категорий
            $category = Category::findOne($category_id);

            $childrenCategoriesIDs = $this->getAllChildrenCategories($category);

            $products->leftJoin('{{%product_category}}', '`product_id` = `id`')
                ->andWhere(['category_id' => $childrenCategoriesIDs]);
        }


        // get min price
        $minPriceProducts = clone $products;
        $productFilter->price_min = $minPriceProducts->min('price');
        // get max price
        $maxPriceProducts = clone $products;
        $productFilter->price_max = $maxPriceProducts->max('price');

        if ($productFilter->condition) {
            $products->andWhere(['condition_id' => $productFilter->condition]);
        }

        if ($productFilter->brand) {
            $products->andWhere(['manufacturer_id' => $productFilter->brand]);
        }

        if ($productFilter->price_from) {
            $products->andWhere(['>=', 'price', $productFilter->price_from]);
        }

        if ($productFilter->price_to) {
            $products->andWhere(['<=', 'price', $productFilter->price_to]);
        }

        if ($productFilter->sort) {
            $products->orderBy( $productFilter->sortSetting );
        } else {
            $products->orderBy(['price' => SORT_ASC]);
        }

        // pagination
        $productsCount = clone $products;
        $pages = new Pagination([
            'totalCount' => $productsCount->count(),
            'defaultPageSize' => $productFilter->per_page ? $productFilter->per_page : 24,
            'page' => $page
        ]);
        $models = $products->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        // GET Products END


        // GET Brands
        $brands = Manufacturer::find()
            ->leftJoin('{{%product}} p', '`manufacturer_id` = p.`id`')
            ->leftJoin('{{%product_category}} pc', 'pc.`product_id` = p.id')
            ->where(['category_id' => $childrenCategoriesIDs])->all();
        // GET Brands END


        $this->view->params['q'] = $q;

        $this->seo(Yii::t('app', 'Search'));


        //echo $products->createCommand()->getRawSql();

        return $this->render('index', [
            'count'             => $pages->totalCount,
            'search_q'          => $q,
            'category'          => $category,
            'products'          => $models,
            'pages'             => $pages,
            'pagination'        => CustomLinkPager::widget([ 'pagination' => $pages ]),
            'filterBrands'      => $brands,
            'productFilter'     => $productFilter,
        ]);
    }

    public function actionAuto($q) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $repo = new ProductRepository();
        $query = $repo->visibleOnTheSite();
        $query->andWhere(['like', 'title', $q]);
        $query->orWhere(['id' => $q]);
        $query->orderBy(['viewed' => SORT_DESC]);
        $products = $query->limit(6)->all();


        $result = ArrayHelper::toArray($products, [
            'common\models\Product' => [
                'title',
                'preview',
                'price' => function ($product) {
                    return Yii::$app->currency->convertAndFormat($product->price, $product->currency);
                },
                'url'
            ]
        ]);
        return $result;
    }

    private function getAllChildrenCategories($category) {
        $childrenCategories = $category->children()->all();

        $childrenCategoriesIDs = [$category->id];
        foreach ($childrenCategories as $cat) {
            $childrenCategoriesIDs[] = $cat->id;
        }

        return $childrenCategoriesIDs;
    }
}