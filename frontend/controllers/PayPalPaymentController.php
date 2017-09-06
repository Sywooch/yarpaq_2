<?php

namespace frontend\controllers;

use Yii;
use common\models\Language;
use common\models\order\Order;
use yii\helpers\Url;

class PayPalPaymentController extends BasicController
{

    public $enableCsrfValidation = false;


    public $freeAccessActions = ['process', 'callback'];
    private $pp_email = 'anar@relax.ae';

    public function actionProcess($order_id) {

        $order = Order::findOne($order_id);

        $products = [];

//        foreach ($this->cart->getProducts() as $product) {
//            $option_data = array();
//
//            foreach ($product['option'] as $option) {
//                if ($option['type'] != 'file') {
//                    $value = $option['value'];
//                } else {
//                    $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
//
//                    if ($upload_info) {
//                        $value = $upload_info['name'];
//                    } else {
//                        $value = '';
//                    }
//                }
//
//                $option_data[] = array(
//                    'name'  => $option['name'],
//                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
//                );
//            }
//
//            $data['products'][] = array(
//                'name'     => htmlspecialchars($product['name']),
//                'model'    => htmlspecialchars($product['model']),
//                'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
//                'quantity' => $product['quantity'],
//                'option'   => $option_data,
//                'weight'   => $product['weight']
//            );
//        }

        // TODO прописать товары в заказ
        foreach ($order->orderProducts as $orderProduct) {
            $product_data = [];

            //$product_data[''] =

            //$products[] = $product_data;
        }




        $tpl_data = [
            'testmode'              => false,
            'text_testmode'         => 'Test mode',

            'action'                => 'https://www.paypal.com/cgi-bin/webscr',
            'business'              => $this->pp_email,
            'products'              => $products,
            'discount_amount_cart'  => 0,
            //'total'                 => $order->total

            'first_name'            => html_entity_decode($order->firstname, ENT_QUOTES, 'UTF-8'),
            'last_name'             => html_entity_decode($order->lastname, ENT_QUOTES, 'UTF-8'),
            'address1'              => html_entity_decode($order->payment_address, ENT_QUOTES, 'UTF-8'),
            'address2'              => html_entity_decode('', ENT_QUOTES, 'UTF-8'),
            'city'                  => html_entity_decode($order->payment_city, ENT_QUOTES, 'UTF-8'),
            'zip'                   => html_entity_decode($order->payment_postcode, ENT_QUOTES, 'UTF-8'),
            'country'               => html_entity_decode($order->payment_country, ENT_QUOTES, 'UTF-8'),
            'email'                 => html_entity_decode($order->email, ENT_QUOTES, 'UTF-8'),
            'invoice'               => $order->id . ' - ' . html_entity_decode($order->payment_city, ENT_QUOTES, 'UTF-8'),
            'lc'                    => Language::findOne( $order->language_id )->name,

            'return_url'            => Url::to(['checkout/success'], true),
            'cancel_url'            => Url::to(['checkout/fail'], true),

            'notify_url'            => Url::to(['pay-pal-payment/callback'], true),

            'paymentaction'         => 'sale',
            'custom'                => $order->id
        ];

        if ($order->total > 0) {
            $tpl_data['products'][] = [
                'name'     => Yii::t('app', 'Total'),
                'model'    => '',
                'price'    => $order->total,
                'quantity' => 1,
                'option'   => [],
                'weight'   => 0
            ];
        }



        return $this->render('index', $tpl_data);
    }

    public function actionCallback() {
        $order_id = (int)Yii::$app->request->post('custom');
        $currency = Yii::$app->currency;

        $order = Order::findOne($order_id);

        if ($order) {

            $request = 'cmd=_notify-validate';

            foreach (Yii::$app->request->post() as $key => $value) {
                $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }


            $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            if (!$response) {
                Yii::error('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
            }

            if (false) { // DEBUG mode
                Yii::error('PP_STANDARD :: IPN REQUEST: ' . $request);
                Yii::error('PP_STANDARD :: IPN RESPONSE: ' . $response);
            }

            if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset(Yii::$app->request->post['payment_status'])) {

                if (Yii::$app->request->post('payment_status')) {

                    $receiver_match = (strtolower(Yii::$app->request->post('receiver_email')) == strtolower($this->pp_email));

                    $total_paid_match = ((float)Yii::$app->request->post('mc_gross') == $currency->convert($order->total, $currency->getCurrencyByCode($order->currency_code), $currency->getCurrencyByCode('USD')));

                    if ($receiver_match && $total_paid_match) {
                        $order->setAsPaid();
                    }

                    if (!$receiver_match) {
                        Yii::error('PP_STANDARD :: RECEIVER EMAIL MISMATCH! ' . strtolower(Yii::$app->request->post['receiver_email']));
                    }

                    if (!$total_paid_match) {
                        Yii::error('PP_STANDARD :: TOTAL PAID MISMATCH! ' . Yii::$app->request->post['mc_gross']);
                    }
                }
            }

            curl_close($curl);

        }
    }
}