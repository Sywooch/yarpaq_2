<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\models\User;

class CheckoutController extends BasicController
{
    public $freeAccessActions = ['index'];

    public function beforeAction($action)
    {
        if ( parent::beforeAction($action) )
        {
            if (Yii::$app->user->isGuest) {
                $this->redirect(Yii::$app->homeUrl);
            }

            return true;
        }

        return false;

    }

    public function actionIndex() {
        $cart       = Yii::$app->cart;
        $user       = Yii::$app->user->identity;
        $address    = $user->addresses[0];

        return $this->render('index', [
            'cart'      => $cart,
            'user'      => $user,
            'address'   => $address
        ]);
    }

}