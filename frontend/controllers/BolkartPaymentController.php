<?php

namespace frontend\controllers;

use Yii;
use common\models\Language;
use common\models\order\Order;
use frontend\models\payment\BolkartPayment;
use frontend\models\payment\BolkartTransaction;


class BolkartPaymentController extends BasicController
{
    public $freeAccessActions = ['process', 'callback'];

    public function actionProcess($order_id) {
        $order = Order::findOne($order_id);

        $bolkart = new BolkartPayment();


        // *** Payment object ***
        $amount         = floor($bolkart->getFilteredParam('amount', $order->total) * 100) / 100;
        $description    = $bolkart->getFilteredParam('item', $order->id);
        $lang           = Language::findOne( $order->language_id )->name;
        $taksit         = Yii::$app->request->get('hint');

        $resp = $bolkart->getPaymentKeyJSONRequest($taksit, $amount, $lang, $description, $order->email, $order->phone1);

        if ($resp->result != 'success') {
            var_dump($resp);
        } else {

            $transaction = new BolkartTransaction();
            $transaction->bolkart_order_id = $order->id;
            $transaction->transaction_id = $resp->id;
            $saved = $transaction->save();

            if ($saved) {
                $this->redirect($resp->paymentUrl);
            }

        }

        return '';
    }

    public function actionCallback($reference) {

        $pk = filter_var($reference, FILTER_SANITIZE_STRING);

        $tr = BolkartTransaction::find()->andWhere(['transaction_id' => $pk])->one();

        if ($tr) {
            $order = Order::findOne($tr->bolkart_order_id);
            $order->setAsPaid();
            $order->save();
        }

    }
}