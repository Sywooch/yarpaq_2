<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\components\CustomLinkPager;
use Yii;
use common\models\category\Category;
use yii\data\Pagination;


class CategoryController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex() {
        $r = Yii::$app->request;

        $url = preg_match('/^[\w_\-\d\/]+$/', $r->get('url')) ? $r->get('url') : '';

        // Поиск среди категорий
        $category = Category::findByUrl($url);

        $products = $category->getProducts()->andWhere(['status_id' => Product::STATUS_ACTIVE]);

        $productsCount = clone $products;
        $pages = new Pagination([
            'totalCount' => $productsCount->count(),
            'defaultPageSize' => 16
        ]);
        $models = $products->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->render('index', [
            'category'      => $category,
            'products'      => $models,
            'pages'         => $pages,
            'pagination'    => CustomLinkPager::widget([ 'pagination' => $pages ])
        ]);
    }
}