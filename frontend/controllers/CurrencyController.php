<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Currency;


class CurrencyController extends BasicController
{

    public $freeAccessActions = ['switch'];

    public function actionSwitch($id) {
        $currency = Currency::findOne($id);

        if (!$currency) {
            throw new NotFoundHttpException();
        }


        Yii::$app->currency->setUserCurrency( $currency );

        return $this->redirect(Yii::$app->request->referrer);
    }
}