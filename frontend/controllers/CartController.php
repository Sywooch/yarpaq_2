<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\models\User;

class CartController extends BasicController
{
    public $freeAccessActions = ['test', 'index', 'add-to-cart'];

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

    /**
     * Ajax действие
     * Добавляет товар в корзину (1 шт)
     */
    public function actionAddToCart() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $r = Yii::$app->request;

        $product_id = (int)$r->post('product_id');

        $cart = Yii::$app->cart;

        $cart->add($product_id, 1);

        if ($cart->save() ) {
            return ['status'  => 1];
        } else {
            return ['status'  => 0];
        }
    }

    public function actionPlus() {

    }

    public function actionMinus() {

    }

    public function actionRemove() {

    }


}