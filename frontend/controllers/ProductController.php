<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\models\ProductRepository;
use frontend\models\ViewedProduct;
use Yii;
use yii\web\NotFoundHttpException;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index'];


    public function actionIndex($id) {

        // Поиск продукта
        $product = Product::findOne($id);

        if (!$product || !$product->isVisible()) {
            throw new NotFoundHttpException();
        }

        ViewedProduct::log($product->id);
        $product->viewed++;
        $product->save();

        $this->seo($product->title, $product->preview->url, $product->description);

        return $this->render('index', [
            'product'      => $product
        ]);

    }
}