<?php

namespace frontend\controllers;

use common\models\Manufacturer;
use common\models\User;
use frontend\models\ProductFilter;
use frontend\models\ProductRepository;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use frontend\components\CustomLinkPager;
use common\models\Product;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class SellerProductsController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex($id) {
        $ajax = false;

        if (Yii::$app->request->isAjax) {
            $ajax = true;
        }
        $r = Yii::$app->request;

        $url = preg_match('/^[\w_\-\d\/]+$/', $r->get('url')) ? $r->get('url') : '';

        // Параметры фильтра
        $productFilter = new ProductFilter();
        $productFilter->load($r->get());

        if (!$productFilter->validate()) {
            throw new Exception('Wrong filter');
        }

        // Поиск среди категорий
        $seller = User::findOne($id);

        if (!$seller) {
            throw new NotFoundHttpException();
        }


        // GET Products
        $repo = new ProductRepository();
        $products = $repo
            ->visibleOnTheSite()
            ->andWhere(['user_id' => $seller->id]);

        // man

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
            ->alias('m')
            ->leftJoin('{{%product}} p', 'p.manufacturer_id = m.id')
            ->where(['p.user_id' => $seller->id])
            ->groupBy('m.id')
            ->all();
        // GET Brands END

        $this->seo($seller->fullname);


        if ($ajax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'markup' => $this->renderPartial('@app/views/blocks/product_list', ['products' => $models]),
                'next_page_url' => $this->getNextPageUrl($pages)
            ];
        } else {
            return $this->render('index', [
                'count'             => $pages->totalCount,
                'seller'            => $seller,
                'products'          => $models,
                'pages'             => $pages,
                'pagination'        => CustomLinkPager::widget([ 'pagination' => $pages ]),
                'filterBrands'      => $brands,
                'productFilter'     => $productFilter,
                'next_page_url'     => $this->getNextPageUrl($pages),
            ]);
        }

    }

    private function getAllChildrenCategories($category) {
        $childrenCategories = $category->children()->all();

        $childrenCategoriesIDs = [$category->id];
        foreach ($childrenCategories as $cat) {
            $childrenCategoriesIDs[] = $cat->id;
        }

        return $childrenCategoriesIDs;
    }

    /**
     * Возвращает URL следующей страницы, если она есть.
     * Иначе пустую строку
     *
     * @param $pages Pagination
     * @return string
     */
    protected function getNextPageUrl($pages) {
        $link = '';

        if (isset($pages->getLinks()[Pagination::LINK_NEXT])) {
            $link = $pages->getLinks()[Pagination::LINK_NEXT];
            $link = str_replace('%2F', '/', $link);
        }

        return $link;
    }
}