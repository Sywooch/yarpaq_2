<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\models\ProductRepository;
use frontend\models\ViewedProduct;
use Yii;
use yii\web\NotFoundHttpException;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index', 'quick-view'];


    public function actionIndex($id) {

        // Поиск продукта
        $product = Product::findOne($id);

        if (!$product) { throw new NotFoundHttpException('Product not found'); }
        if (!$product->isVisible()) { throw new NotFoundHttpException('Product is not shown on the site'); }

        ViewedProduct::log($product->id);
        $product->viewed++;
        $product->save();

        $this->seo($product->title, $product->preview->url, $product->description, null, 'product');

        return $this->render('index', [
            'product'      => $product
        ]);

    }

    public function actionQuickView($id) {

        // Поиск продукта
        $product = Product::findOne($id);

        if (!$product || !$product->isVisible()) {
            throw new NotFoundHttpException();
        }

        ViewedProduct::log($product->id);
        $product->viewed++;
        $product->save();

        return $this->renderPartial('quick_view', [
            'product'      => $product
        ]);

    }
}