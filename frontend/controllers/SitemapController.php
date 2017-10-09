<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use frontend\models\CategoryRepository;
use frontend\models\ProductRepository;

class SitemapController extends BasicController
{
    public $freeAccessActions = ['products', 'categories'];

    public function actionProducts($num) {
        $this->setAsXML();

        $offset = ((int)$num - 1) * 1000;
        $products = (new ProductRepository())
            ->visibleOnTheSite()
            ->offset($offset)
            ->limit(1000)
            ->all();

        return $this->renderPartial('products', [
            'products'  => $products
        ]);
    }

    public function actionCategories() {
        $this->setAsXML();

        $categories = (new CategoryRepository())
            ->visibleOnTheSite()
            ->all();

        return $this->renderPartial('categories', [
            'categories' => $categories,
        ]);
    }

    private function setAsXML() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
    }
}