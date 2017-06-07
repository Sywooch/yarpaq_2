<?php

namespace frontend\controllers;

use Yii;

class CartController extends BasicController
{
    public $freeAccessActions = ['test'];

    public function actionTest() {
        $cart = Yii::$app->cart;

        var_dump($cart->products);
    }
}