<?php

namespace frontend\controllers;

use frontend\models\ProductRepository;
use frontend\models\ViewedProduct;
use Yii;
use yii\web\NotFoundHttpException;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index'];


    public function actionIndex($id) {

        // Поиск продукта
        $repo = new ProductRepository();

        $product = $repo
            ->visibleOnTheSite()
            ->andWhere(['id' => $id])
            ->one();

        if (!$product) {
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