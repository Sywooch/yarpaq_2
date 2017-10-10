<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\Language;
use common\models\notification\NewOrderAdminNotification;
use common\models\notification\NewOrderUserNotification;
use common\models\order\Order;
use common\models\order\OrderProduct;
use common\models\OrderOption;
use common\models\payment\PaymentMethod;
use common\models\Product;
use common\models\shipping\Shipping;
use common\models\shipping\ShippingMethod;
use common\models\Zone;
use Yii;
use yii\helpers\BaseInflector;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CheckoutController extends BasicController
{
    public $freeAccessActions = ['index', 'confirm', 'success', 'fail', 'zones'];

    /**
     * Страница сбора данных для оформления заказа
     * - сбор данных о покупалете
     * - выбор метода доставки
     * - выбор метода оплаты
     *
     * @return string|void
     */
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

        $this->seo(Yii::t('app', 'Checkout'));

        return $this->render('index', [
            'cart'              => $cart,
            'user'              => $user,
            'payment_info'      => $session->get('payment_info'),
            'shipping_info'     => $session->get('shipping_info'),
            'user_info'         => $session->get('user_info')
        ]);
    }

    // TODO доложно быть POST, передаются данные оплаты и доставки

    /**
     * Непостредственное техническое оформление заказа
     * - создание заказа в базе данных
     * - вычетание товара из стока
     * - переброс на страницу оплаты
     *
     * @throws BadRequestHttpException
     * @throws \yii\db\Exception
     */
    public function actionConfirm() {
        $request        = Yii::$app->request;
        $cart           = Yii::$app->cart;
        $user           = Yii::$app->user->identity;
        $session        = Yii::$app->session;
        $currency       = Yii::$app->currency;


        // get payment method
        if ($request->post('payment_method')) {

            if (strpos($request->post('payment_method'), '.') !== false) {
                $pm = explode('.', $request->post('payment_method'));

                $payment_method_id = $pm[0];
                $payment_method_hint = $pm[1];
            } else {
                $payment_method_id = $request->post('payment_method');
                $payment_method_hint = '';
            }

            $payment_method_model = PaymentMethod::findOne($payment_method_id);

            if ($payment_method_model) {
                $payment_method_data = [
                    'title' => $payment_method_model->name,
                    'code'  => $payment_method_model->code,
                    'class' => $payment_method_model->class
                ];
                $session->set('payment_method', $payment_method_data);
            }
        }


        // Validate cart has products and has stock.
        if (!$cart->hasProducts() || !$cart->hasStock()) {
            $this->redirect(Url::toRoute(['/cart']));
            return;
        }


        $order = new Order();

        if ($user) {

            $order->user_id    = $user->id;
            $order->firstname  = $user->profile->firstname;
            $order->lastname   = $user->profile->lastname;
            $order->email      = $user->email;
            $order->phone1     = $user->profile->phone1;
            $order->phone2     = $user->profile->phone2;
            $order->fax        = $user->profile->fax;

        } else {

            $order->firstname  = $request->post('shipping_firstname');
            $order->lastname   = $request->post('shipping_lastname');
            $order->email      = $request->post('email');
            $order->phone1     = $request->post('phone1');
            $order->phone2     = $request->post('phone2');
            $order->fax        = $request->post('fax');

        }

        $order->payment_firstname       = $request->post('shipping_firstname');
        $order->payment_lastname        = $request->post('shipping_lastname');
        $order->payment_company         = $request->post('shipping_company');
        $order->payment_address         = $request->post('shipping_address');
        $order->payment_city            = $request->post('shipping_city');
        $order->payment_postcode        = $request->post('shipping_postcode');
        $order->payment_zone_id         = $request->post('shipping_zone_id');
        $order->payment_zone            = Zone::findOne($request->post('shipping_zone_id'))->name;
        $order->payment_country_id      = $request->post('shipping_country_id');
        $order->payment_country         = Country::findOne($request->post('shipping_country_id'))->name;

        $payment_method = $session->get('payment_method');

        $order->payment_method          = $payment_method['title'];
        $order->payment_code            = $payment_method['code'];


        $zone = Zone::findOne($request->post('shipping_zone_id'));
        $geo_zones = $zone->geoZones;
        $main_geo_zone = $geo_zones[0];

        $order->shipping_firstname      = $request->post('shipping_firstname');
        $order->shipping_lastname       = $request->post('shipping_lastname');
        $order->shipping_company        = $request->post('shipping_company');
        $order->shipping_address        = $request->post('shipping_address');
        $order->shipping_city           = $request->post('shipping_city');
        $order->shipping_postcode       = $request->post('shipping_postcode');
        $order->shipping_zone_id        = $request->post('shipping_zone_id');
        $order->shipping_zone           = $zone->name;
        $order->shipping_country_id     = $request->post('shipping_country_id');
        $order->shipping_country        = Country::findOne($request->post('shipping_country_id'))->name;



        $shipping_method_id = $request->post('shipping_method');

        $shipping_method = ShippingMethod::findOne($shipping_method_id);
        if (!$shipping_method) { throw new BadRequestHttpException('Unknown shipping method'); }
        $shipping_method_obj = Shipping::create($shipping_method->name);

        $order->shipping_method         = $shipping_method->name;
        $order->shipping_code           = $shipping_method->code;

        $order->comment                 = $session->get('comment');
        $order->total                   = $cart->total;



        // add shipping
        foreach ($cart->getProducts() as $product) {
            $order->total += $shipping_method_obj->calculateCost($product['weight'], $main_geo_zone->geo_zone_id);
        }

        $order->currency_id             = $currency->userCurrency->id;
        $order->currency_code           = $currency->userCurrency->code;

        $order->language_id             = Language::getCurrent()->id;


        $db     = $order->getDb();
        $trans  = $db->beginTransaction();

        $orderSaved = $order->save();
        if ($orderSaved) {

            // сохранение "товаров заказа"
            foreach ($cart->products as $key => $product) {

                $orderProduct = new OrderProduct();

                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product['product_id'];
                $orderProduct->name = $product['title'];
                $orderProduct->model = $product['model'];
                $orderProduct->quantity = $product['quantity'];
                $orderProduct->price = $product['price'];
                $orderProduct->total = $product['total'];

                if ($orderProduct->save()) {

                    // если успещно сохранили "товар заказа"
                    // то надо вычесть количество из стока
                    $_product = Product::findOne($orderProduct->product_id);
                    $_product->quantity -= $orderProduct->quantity;
                    $_product->save();

                } else {
                    $trans->rollBack();
                }

                // сохранение опций "товаров заказа"
                foreach ($product['option'] as $option) {
                    $orderOption = new OrderOption();

                    $orderOption->order_id                  = $order->id;
                    $orderOption->product_option_id         = $option['product_option_id'];
                    $orderOption->product_option_value_id   = $option['product_option_value_id'];
                    $orderOption->order_product_id          = $orderProduct->id;
                    $orderOption->name                      = $option['name'];
                    $orderOption->value                     = $option['value'];
                    $orderOption->type                      = $option['type'];

                    if (!$orderOption->save()) {
                        $trans->rollBack();
                    }
                }
            }

            if ($trans->isActive) {
                $trans->commit();

                $session->remove('payment_method');
                $session->remove('shipping_method');
                $session->remove('guest');

                //$userNotification = new NewOrderUserNotification($user, $order);
                //$userNotification->send();

                $adminNotification = new NewOrderAdminNotification($user, $order);
                $adminNotification->send();



                // Redirect to payment page
                $payment_class = BaseInflector::camel2id($payment_method['class']);
                $this->redirect(Url::toRoute([$payment_class.'/process', 'order_id' => $order->id, 'hint' => $payment_method_hint]));

            } else {
                // Redirect to checkout page
                $this->redirect(Url::toRoute('fail'));
            }

        }

    }

    public function actionZones($country_id) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ArrayHelper::map( Zone::find()->andWhere(['country_id' => $country_id])->all(), 'id', 'name' );
    }

    public function actionSuccess() {
        $cart           = Yii::$app->cart;
        $cart->clear();
        $cart->save();

        return $this->render('success');
    }

    public function actionFail() {
        return $this->render('fail');
    }
}