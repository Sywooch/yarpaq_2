<?php

namespace frontend\controllers;

use frontend\models\AddToCartForm;
use Yii;
use yii\helpers\Url;
use common\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class CartController extends BasicController
{
    public $freeAccessActions = ['index', 'add', 'update', 'remove'];

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

        $addToCartForm->load(Yii::$app->request->post());
        $addToCartForm->quantity = 1;

        if ($addToCartForm->validate()) {
            $cart = Yii::$app->cart;

            $cart->add($addToCartForm->productId, $addToCartForm->quantity, $addToCartForm->option);
            $cart->save();

            $this->redirect( Url::toRoute('index') );
        }

    }

    public function actionUpdate() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->post('product_id') || !Yii::$app->request->post('qty')) {
            throw new BadRequestHttpException('invalid data');
        }

        $product_id = (int) Yii::$app->request->post('product_id');
        $qty = (int) Yii::$app->request->post('qty');

        $cart = Yii::$app->cart;
        $products = $cart->products;

        foreach ($products as $key => $product) {
            if ($product['product_id'] == $product_id) {
                $cart->update($key, $qty);
                $cart->save();

                return [
                    'status' => 1,
                    'total' => Yii::$app->currency->convertAndFormat($cart->subTotal, Yii::$app->currency->getCurrencyByCode($product['currency_code']))
                ];
            }
        }

        return ['status' => 0];
    }

    public function actionRemove() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->post('product_id')) {
            throw new BadRequestHttpException('invalid data');
        }

        $product_id = (int) Yii::$app->request->post('product_id');

        $cart = Yii::$app->cart;
        $products = $cart->products;

        foreach ($products as $key => $product) {
            if ($product['product_id'] == $product_id) {
                $cart->remove($key);
                $cart->save();

                return [
                    'status' => 1,
                    'total' => Yii::$app->currency->convertAndFormat($cart->subTotal, Yii::$app->currency->getCurrencyByCode($product['currency_code']))
                ];
            }
        }

        return ['status' => 0];
    }


}