<?php

namespace frontend\controllers;

use common\models\User;
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

        $users = User::find()->all();

        foreach ($users as $user) {

            $cart = $user->cart;


            if ($cart == '') continue;

            $cart = unserialize($cart);

            foreach ($cart as $key => $quantity) {
                $product = unserialize(base64_decode($key));

                $product_id = $product['product_id'];

                if ($product_id >= 1866) {
                    echo $user->id .' - '.$product_id.'<br>';
                }
            }

        }

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