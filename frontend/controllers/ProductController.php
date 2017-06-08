<?php

namespace frontend\controllers;

use frontend\models\ViewedProduct;
use Yii;
use common\models\Product;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index'];


    public function actionIndex($id) {
        $r = Yii::$app->request;

        // Поиск продукта
        $product = Product::findOne($id);

        if ($product) {

            ViewedProduct::log($product->id);

            return $this->render('index', [
                'product'      => $product
            ]);
        } else {

        }

    }
}