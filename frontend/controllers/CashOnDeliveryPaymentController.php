<?php

namespace frontend\controllers;


use webvimark\components\BaseController;
use yii\helpers\Url;

class CashOnDeliveryPaymentController extends BaseController
{
    public $freeAccessActions = ['process'];

    public function actionProcess() {
        $this->redirect(Url::toRoute(['checkout/success']));
    }

}