<?php

namespace frontend\controllers;

use common\models\Language;
use common\models\notification\NewOrderAdminNotification;
use common\models\notification\NewOrderUserNotification;
use common\models\order\Order;
use common\models\order\OrderProduct;
use common\models\OrderOption;
use common\models\payment\PaymentMethod;
use common\models\shipping\ShippingMethod;
use Yii;
use yii\helpers\Url;

class CheckoutController extends BasicController
{
    public $freeAccessActions = ['index', 'confirm', 'success', 'fail'];

    public function actionIndex() {
        $session    = Yii::$app->session;
        $cart       = Yii::$app->cart;
        $user       = Yii::$app->user->identity;

        if (!$cart->hasProducts() || !$cart->hasStock()) {
            $this->redirect(Url::toRoute(['/cart']));
            return;
        }


        if ($user && count($user->addresses)) {
            $address = $user->addresses[0];

            $payment_info = [];
            $payment_info['firstname']   = $address->firstname;
            $payment_info['lastname']    = $address->lastname;
            $payment_info['company']     = $address->company;
            $payment_info['address']     = $address->address_1;
            $payment_info['city']        = $address->city;
            $payment_info['postcode']    = $address->postcode;
            $payment_info['zone']        = $address->zone->name;
            $payment_info['zone_id']     = $address->zone_id;
            $payment_info['country']     = $address->country->name;
            $payment_info['country_id']  = $address->country_id;

            $session->set('payment_info', $payment_info);


            $shipping_info = [];
            $shipping_info['firstname']   = $address->firstname;
            $shipping_info['lastname']    = $address->lastname;
            $shipping_info['company']     = $address->company;
            $shipping_info['address']     = $address->address_1;
            $shipping_info['city']        = $address->city;
            $shipping_info['postcode']    = $address->postcode;
            $shipping_info['zone']        = $address->zone->name;
            $shipping_info['zone_id']     = $address->zone_id;
            $shipping_info['country']     = $address->country->name;
            $shipping_info['country_id']  = $address->country_id;

            $session->set('shipping_info', $shipping_info);


            $user_info = [];
            $user_info['phone1']    = $user->profile->phone1;
            $user_info['email']     = $user->email;

            $session->set('user_info', $user_info);
        }

        return $this->render('index', [
            'cart'              => $cart,
            'user'              => $user,
            'payment_info'      => $session->get('payment_info'),
            'shipping_info'     => $session->get('shipping_info'),
            'user_info'         => $session->get('user_info')
        ]);
    }

    public function actionConfirm() {
        $request        = Yii::$app->request;
        $cart           = Yii::$app->cart;
        $user_component = Yii::$app->user;
        $user           = Yii::$app->user->identity;
        $session        = Yii::$app->session;
        $currency       = Yii::$app->currency;


        // get payment method
        if ($request->post('payment_method')) {
            $payment_method_model = PaymentMethod::findOne($request->post('payment_method'));

            if ($payment_method_model) {
                $payment_method_data = [
                    'title' => $payment_method_model->name,
                    'code'  => $payment_method_model->code,
                    'class' => $payment_method_model->class
                ];
                $session->set('payment_method', $payment_method_data);
            }
        }

        // get shipping method
        if ($request->post('shipping_method')) {
            $shipping_method_model = ShippingMethod::findOne($request->post('shipping_method'));

            if ($shipping_method_model) {
                $shipping_method_data = [
                    'title' => $shipping_method_model->name,
                    'code' => $shipping_method_model->code
                ];
                $session->set('shipping_method', $shipping_method_data);
            }
        }


        // Validate cart has products and has stock.
        if (!$cart->hasProducts() || !$cart->hasStock()) {
            $this->redirect(Url::toRoute(['/cart']));
            return;
        }


        $order = new Order();

        if (!$user_component->isGuest) {

            $order->user_id    = $user->id;
            $order->firstname  = $user->profile->firstname;
            $order->lastname   = $user->profile->lastname;
            $order->email      = $user->email;
            $order->phone1     = $user->profile->phone1;
            $order->phone2     = $user->profile->phone2;
            $order->fax        = $user->profile->fax;

        } elseif ($session->has('guest')) {

            $guest = $session->get('guest');

            $order->user_id    = 0;
            $order->firstname  = $guest['firstname'];
            $order->lastname   = $guest['lastname'];
            $order->email      = $guest['email'];
            $order->phone1     = $guest['phone1'];
            $order->phone2     = $guest['phone2'];
            $order->fax        = $guest['fax'];
        }
        $payment_address = $session->get('payment_address');

        $order->payment_firstname       = $payment_address['firstname'];
        $order->payment_lastname        = $payment_address['lastname'];
        $order->payment_company         = $payment_address['company'];
        $order->payment_address         = $payment_address['address'];
        $order->payment_city            = $payment_address['city'];
        $order->payment_postcode        = $payment_address['postcode'];
        $order->payment_zone            = $payment_address['zone'];
        $order->payment_zone_id         = $payment_address['zone_id'];
        $order->payment_country         = $payment_address['country'];
        $order->payment_country_id      = $payment_address['country_id'];



        $payment_method = $session->get('payment_method');

        $order->payment_method          = $payment_method['title'];
        $order->payment_code            = $payment_method['code'];



        $shipping_address = $session->get('shipping_address');

        $order->shipping_firstname      = $shipping_address['firstname'];
        $order->shipping_lastname       = $shipping_address['lastname'];
        $order->shipping_company        = $shipping_address['company'];
        $order->shipping_address        = $shipping_address['address'];
        $order->shipping_city           = $shipping_address['city'];
        $order->shipping_postcode       = $shipping_address['postcode'];
        $order->shipping_zone           = $shipping_address['zone'];
        $order->shipping_zone_id        = $shipping_address['zone_id'];
        $order->shipping_country        = $shipping_address['country'];
        $order->shipping_country_id     = $shipping_address['country_id'];



        $shipping_method = $session->get('shipping_method');

        $order->shipping_method         = $shipping_method['title'];
        $order->shipping_code           = $shipping_method['code'];

        $order->comment                 = $session->get('comment');
        $order->total                   = $cart->total;

        $order->currency_id             = $currency->userCurrency->id;
        $order->currency_code           = $currency->userCurrency->code;

        $order->language_id             = Language::getCurrent()->id;


        $db     = $order->getDb();
        $trans  = $db->beginTransaction();

        $orderSaved = $order->save();

        //var_dump($order->getErrors());

        if ($orderSaved) {

            foreach ($cart->products as $key => $product) {

                $orderProduct = new OrderProduct();

                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product['product_id'];
                $orderProduct->name = $product['title'];
                $orderProduct->model = $product['model'];
                $orderProduct->quantity = $product['quantity'];
                $orderProduct->price = $product['price'];
                $orderProduct->total = $product['total'];

                if (!$orderProduct->save()) {
                    $trans->rollBack();
                    //var_dump($orderProduct->getErrors());
                }

                foreach ($product['option'] as $option) {
                    $orderOption = new OrderOption();

                    $orderOption->order_id = $order->id;
                    $orderOption->product_option_id = $option['product_option_id'];
                    $orderOption->product_option_value_id = $option['product_option_value_id'];
                    $orderOption->option_id = $option['option_id'];
                    $orderOption->option_value_id = $option['option_value_id'];
                    $orderOption->name = $option['name'];
                    $orderOption->value = $option['value'];
                    $orderOption->type = $option['type'];

                    if (!$orderOption->save()) {
                        $trans->rollBack();
                        //var_dump($orderOption->getErrors());
                    }
                }
            }

            if ($trans->isActive) {
                $trans->commit();

                $cart->clear();
                $cart->save();
                $session->remove('payment_method');
                $session->remove('shipping_method');
                $session->remove('guest');

                //$userNotification = new NewOrderUserNotification($user, $order);
                //$userNotification->send();

                $adminNotification = new NewOrderAdminNotification($user, $order);
                $adminNotification->send();



                // Redirect to payment page
                $this->redirect(Url::toRoute('success'));
                //$payment_class = $payment_method['class'];
                //$this->redirect(Url::toRoute([$payment_class.'/checkout', 'order_id' => $order->id]));
            } else {
                // Redirect to checkout page
                $this->redirect(Url::toRoute('fail'));
            }

        }

    }

    public function actionSuccess() {
        return $this->render('success');
    }

    public function actionFail() {
        return $this->render('fail');
    }
}