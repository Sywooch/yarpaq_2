<?php

namespace frontend\controllers;


use webvimark\components\BaseController;
use yii\helpers\Url;

class CashOnDeliveryPaymentController extends BaseController
{
    public $freeAccessActions = ['success'];

    public function actionSuccess() {
        $this->redirect(Url::toRoute(['checkout/success']));
    }

}