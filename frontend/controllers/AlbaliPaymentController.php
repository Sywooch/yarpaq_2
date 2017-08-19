<?php

namespace frontend\controllers;

use Yii;
use common\models\Language;
use common\models\order\Order;
use frontend\models\payment\AlbaliPayment;
use frontend\models\payment\AlbaliTransaction;


class AlbaliPaymentController extends BasicController
{
    public $freeAccessActions = ['process', 'callback'];

    public function actionProcess($order_id) {
        $order = Order::findOne($order_id);

        $albali = new AlbaliPayment();

        // *** Payment object ***
        $amount         = intval($albali->getFilteredParam('amount', $order->total * 100));
        $description    = $albali->getFilteredParam('item', $order->id);
        $lang           = Language::findOne( $order->language_id )->name;
        $taksit         = Yii::$app->request->get('hint');
        $merchant       = $albali->getMerchantByTaksit($taksit);
        $reference      = md5(time());
        $resp           = $albali->getPaymentKeyJSONRequest($taksit, $amount, $lang, $reference, $description);


        if ($resp->code != 0) {

        } else {

            $transaction = new AlbaliTransaction();
            $transaction->millikart_order_id = $order->id;
            $transaction->transaction_id = $reference;
            $transaction->mid = $merchant;
            $saved = $transaction->save();

            if ($saved) {
                $this->redirect($resp->redirect);
            }

        }

        return '';
    }

    public function actionCallback($reference) {

        $pk = filter_var($reference, FILTER_SANITIZE_STRING);

        $tr = AlbaliTransaction::find()->andWhere(['transaction_id' => $pk])->one();

        if ($tr) {
            $order = Order::findOne($tr->millikart_order_id);
            $order->setAsPaid();
            $order->save();
        }

    }
}