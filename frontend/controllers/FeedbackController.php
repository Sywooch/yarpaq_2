<?php

namespace frontend\controllers;

use common\models\review\Review;
use common\models\User;
use Yii;
use common\models\order\OrderProduct;
use frontend\models\LeaveFeedbackForm;
use yii\base\Exception;
use yii\helpers\Url;

class FeedbackController extends BasicController
{
    public $freeAccessActions = ['leave'];


    public function actionLeave($order_product_id) {

        $orderProduct = OrderProduct::findOne($order_product_id);

        if (!$orderProduct) {
            throw new Exception('Unknown product');
        }

        $leaveFeedbackForm = new LeaveFeedbackForm();
        if ($leaveFeedbackForm->load(Yii::$app->request->post()) && $leaveFeedbackForm->validate()) {

            $review = new Review();
            $review->customer_id    = User::getCurrentUser()->id;
            $review->product_id     = $orderProduct->product_id;
            $review->seller_id      = $orderProduct->product->user_id;

            $review->review         = $leaveFeedbackForm->comment;
            $review->post_date      = (new \DateTime())->format('Y-m-d H:i:s');
            $review->stars          = $leaveFeedbackForm->stars;

            try {
                if ($review->save() ) {
                    $this->redirect(Url::to(['feedback/success']));
                }
            } catch (\yii\db\Exception $e) {
                Yii::error($e->getMessage());
            }
        }

        return $this->render('leave', [
            'leaveFeedbackForm' => $leaveFeedbackForm,
            'order_id'          => $orderProduct->order_id,
            'product'           => $orderProduct->product
        ]);
    }

    public function actionSuccess() {
        return $this->render('success');
    }

}