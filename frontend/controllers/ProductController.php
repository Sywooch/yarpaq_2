<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex($id) {
        $r = Yii::$app->request;

        $url = preg_match('/^[\w_\-\d\/]+$/', $r->get('url')) ? $r->get('url') : '';

        // Поиск продукта
        $product = Product::findOne($id);

        return $this->render('index', [
            'product'      => $product
        ]);
    }
}