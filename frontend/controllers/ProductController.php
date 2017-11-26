<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\models\ProductRepository;
use frontend\models\ViewedProduct;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;


class ProductController extends BasicController
{

    public $freeAccessActions = ['index', 'quick-view'];


    public function actionIndex($id) {

        // Поиск продукта
        $product = Product::findOne($id);

        if (!$product) { throw new NotFoundHttpException('Product not found'); }


        if (!$product->isVisible()) {

            // если товар скрыт, то пытаемся перейти на его родительскую категорию, если она есть
            if (isset($product->category[0]) && $product->category[0]) {
                $product_category = $product->category[0];
                $this->redirect($product_category->url, 301);
            }

            // если товар не привязан к категории то перебросить его название в поиск
            else {
                $this->redirect(['search/elastic', 'q' => $product->title], 301);
            }
        }

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