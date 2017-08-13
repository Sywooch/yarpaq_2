<?php

namespace frontend\controllers;

use frontend\models\AddToCartForm;
use Yii;
use yii\helpers\Url;
use common\models\User;

class CartController extends BasicController
{
    public $freeAccessActions = ['test', 'index', 'add'];

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
     * Добавляет товар в корзину (1 шт)
     *
     */
    public function actionAdd() {
        $addToCartForm = new AddToCartForm();

        $addToCartForm->load(Yii::$app->request->post('Product'));
        $addToCartForm->quantity = 1;

        if ($addToCartForm->validate()) {
            $cart = Yii::$app->cart;

            $cart->add($addToCartForm->productId, $addToCartForm->quantity);
            $cart->save();

            $this->redirect( Url::toRoute('index') );
        }

    }

    public function actionPlus() {

    }

    public function actionMinus() {

    }

    public function actionRemove() {

    }


}