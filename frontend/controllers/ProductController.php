<?php

namespace frontend\controllers;

use frontend\models\ViewedProduct;
use Yii;
use common\models\Product;
use yii\web\NotFoundHttpException;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index'];


    public function actionIndex($id) {

        // Поиск продукта
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException();
        }

        ViewedProduct::log($product->id);
        $product->viewed++;
        $product->save();

        return $this->render('index', [
            'product'      => $product
        ]);

    }
}