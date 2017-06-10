<?php

namespace frontend\controllers;

use Yii;

class CartController extends BasicController
{
    public $freeAccessActions = ['test', 'index'];

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

    public function actionTest() {
        $cart = Yii::$app->cart;

        var_dump($cart->products);
    }

    public function actionIndex() {
        $cart = Yii::$app->cart;

        return $this->render('index', [
            'cart' => $cart
        ]);
    }

    public function actionPlus() {

    }

    public function actionMinus() {

    }

    public function actionRemove() {

    }


}