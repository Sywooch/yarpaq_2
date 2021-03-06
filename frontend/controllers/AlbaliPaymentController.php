<?php

namespace frontend\controllers;

use frontend\components\taksit\Albali;
use Yii;
use common\models\Language;
use common\models\order\Order;
use frontend\models\payment\AlbaliPayment;
use frontend\models\payment\AlbaliTransaction;
use yii\helpers\Url;


class AlbaliPaymentController extends BasicController
{
    public $freeAccessActions = ['process', 'callback'];

    public function actionProcess($order_id) {
        $order = Order::findOne($order_id);

        $albali = new AlbaliPayment();

        // *** Payment object ***


        $taksit         = Yii::$app->request->get('hint');

        // надбавляем процент
        $albaliTaksit = new Albali($order->total);
        $amount         = intval($albali->getFilteredParam('amount', $albaliTaksit->getTotalAmount($taksit) * 100));

        $description    = $albali->getFilteredParam('item', $order->id);
        $lang           = Language::findOne( $order->language_id )->name;
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
        $success = false;
        $pk = filter_var($reference, FILTER_SANITIZE_STRING);

        $tr = AlbaliTransaction::find()->andWhere(['transaction_id' => $pk])->one();

        if ($tr) {
            $order = Order::findOne($tr->millikart_order_id);
            $order->setAsPaid();
            $success = $order->save();
        }

        if ($success) {
            $this->redirect(Url::toRoute(['checkout/success']));
        }

    }
}