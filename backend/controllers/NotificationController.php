<?php

namespace backend\controllers;

use common\models\order\Order;
use common\models\Product;
use common\models\review\Review;
use Yii;
use webvimark\components\AdminDefaultController;
use yii\web\Response;

class NotificationController extends AdminDefaultController
{

    public $freeAccessActions = ['common-for-admin'];

    public function actionCommonForAdmin() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // товары на модерации
        $moderation_products = Product::find()
            ->andWhere(['moderated' => 0])
            ->count();


        // новые заказы
        $new_orders = Order::find()
            ->andWhere(['order_status_id' => 0])
            ->count();


        $new_reviews = Review::find()
            ->andWhere(['status' => 0])
            ->count();


        // Товары c нулевым количеством
        $out_of_stock_products = Product::find()
            ->andWhere(['quantity' => 0])
            ->count();


        $total = $moderation_products + $new_orders + $new_reviews + $out_of_stock_products;

        return [
            'moderation_products'       => $moderation_products,
            'new_orders'                => $new_orders,
            'new_reviews'               => $new_reviews,
            'out_of_stock_products'     => $out_of_stock_products,
            'total'                     => $total
        ];

    }

    public function actionCommonForSeller() {

    }
}