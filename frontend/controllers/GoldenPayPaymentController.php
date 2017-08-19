<?php

namespace frontend\controllers;

use Yii;
use common\models\Language;
use common\models\order\Order;
use frontend\models\payment\GoldenPayPayment;
use frontend\models\payment\GoldenPayTransaction;


class GoldenPayPaymentController extends BasicController
{
    public $freeAccessActions = ['process', 'callback'];

    public function actionProcess($order_id) {
        $order = Order::findOne($order_id);

        $goldenPay = new GoldenPayPayment();

        // *** Payment object ***
        $goldenPay->amount = $order->total*100;
        $goldenPay->cardType = Yii::$app->request->get('hint');
        $goldenPay->description = 'Order - '.$order->id;
        $goldenPay->lang = Language::findOne( $order->language_id )->name;

        if ($goldenPay->validate()) {
            $resp = $goldenPay->getPaymentKeyJSONRequest();

            if ($resp->status->code != 1) {
                echo 'error';
            } else {

                $transaction = new GoldenPayTransaction();
                $transaction->goldenpay_order_id = $order->id;
                $transaction->transaction_id = $resp->paymentKey;
                $saved = $transaction->save();

                if ($saved) {
                    $this->redirect($resp->urlRedirect);
                }
            }
        }

        return '';
    }

    public function actionCallback($payment_key) {

        $pk = filter_var($payment_key, FILTER_SANITIZE_STRING);

        $tr = GoldenPayTransaction::find()->andWhere(['transaction_id' => $pk])->one();

        if ($tr) {
            $order = Order::findOne($tr->goldenpay_order_id);
            $order->setAsPaid();
            $order->save();
        }

    }
}