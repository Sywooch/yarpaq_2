<?php

namespace frontend\controllers;

use common\models\Manufacturer;
use frontend\models\ProductFilter;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use frontend\components\CustomLinkPager;
use common\models\Product;
use common\models\category\Category;
use common\models\search\SearchLogger;


class SearchController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex() {
        $r = Yii::$app->request;

        $q = null;
        $category = null;
        $childrenCategoriesIDs = [];

        // Параметры фильтра
        $productFilter = new ProductFilter();
        $productFilter->load($r->get());

        if (!$productFilter->validate()) {
            throw new Exception('Wrong filter');
        }

        // GET Products
        $products = Product::find();

        if ($r->get('q')) {
            $q = htmlentities(strip_tags($r->get('q')));

            SearchLogger::log($q);
        }

        $products->andWhere(['like', 'title', $q]);

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
            'defaultPageSize' => $productFilter->per_page ? $productFilter->per_page : 24
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

    private function getAllChildrenCategories($category) {
        $childrenCategories = $category->children()->all();

        $childrenCategoriesIDs = [$category->id];
        foreach ($childrenCategories as $cat) {
            $childrenCategoriesIDs[] = $cat->id;
        }

        return $childrenCategoriesIDs;
    }
}