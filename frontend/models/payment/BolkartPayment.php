<?php

namespace frontend\models\payment;

class BolkartPayment extends Payment {

    private $urlGetPaymentKey     = 'https://epos.az/api/pay2me/pay/';
    private $urlGetPaymentResult  = 'https://epos.az/api/pay2me/status/';

    private $merchantName   = 'www.yarpaq.az';
    private $authKey        = 'IePyZC94UA0VDjn6TkkPHQa0cGBPXp';
    private $privateKey     = 'CvtiUjKTdvk4gOduKWFUBcBB2D8ujV';

    protected $moduleName   = 'bolkart';
    protected $cardType     = 2;

    protected $successUrl = 'https://yarpaq.az/index.php?route=checkout/success';
    protected $errorUrl = 'https://yarpaq.az/index.php?route=checkout/fail';

    protected $rates = [
        '1' => 1.8,
        '3' => 5.8,
        '6' => 9.8,
        //'12' => 16
    ];


    private function getRequest($url, $params) {
        return file_get_contents($url . '?' . http_build_query($params), false);
    }

    /**
     * Отправляет запрос на регистрацию оплаты
     * Возвращает JSON ответ:
     * {"result":"success","paymentUrl":"http://site.com/id/ffg3543ergerg","id":"586"}
     */
    public function getPaymentKeyJSONRequest($taksit, $amount, $language, $description, $email, $phone, $currency = 944) {
        $params = [];

        $hashSum = $this->getHashcCode($amount, $phone, $email, $description, $taksit, 'DESKTOP', $this->successUrl, $this->errorUrl, $currency);

        $params['key'] = $this->authKey;
        $params['sum'] = $hashSum;
        $params['amount'] = $amount;
        $params['phone'] = $phone;
        $params['email'] = $email; // required
        $params['description'] = $description; // required
        $params['cardType'] = $this->cardType; // 0=>'Visa', 1=>'MasterCard', 2=>'Bolkart'
        $params['taksit'] = $taksit;
        $params['successUrl'] = $this->successUrl;
        $params['errorUrl'] = $this->errorUrl;
        $params['payFormType'] = 'DESKTOP'; // DESKTOP / MOBILE
        $params['currency'] = $currency;

        //var_dump($params);

        $response = json_decode($this->getRequest($this->urlGetPaymentKey, $params));

        //var_dump($response);

        return $response;
    }


    public function getPaymentResult($reference, $mid) {
        $params = array(
            'mid' => $mid,
            'reference' => $reference
        );

        $response = file_get_contents($this->urlGetPaymentResult."?".http_build_query($params), false);
        $respObject = simplexml_load_string($response);

        return $respObject;

        //$this->log('Bolkart GetPaymentResult ('.date('d.m.Y H:i:s').')'.PHP_EOL . $response);
    }


    private function getHashcCode($amount, $phone, $email, $description, $taksit, $payFormType, $successUrl, $errorUrl, $currency) {
        $params = [];

        $params['amount'] = $amount;
        $params['phone'] = $phone;
        $params['email'] = $email;
        $params['description' ] = $description;
        $params['cardType' ] = $this->cardType;
        $params['taksit' ] = $taksit;
        $params['payFormType' ] = $payFormType;
        $params['successUrl' ] = $successUrl;
        $params['errorUrl' ] = $errorUrl;
        $params['key'] = $this->authKey;
        $params['currency'] = $currency;

        //var_dump($params);

        ksort($params);
        $sum = '';
        foreach ($params as $k => $v) {
            $sum .= $v;
        }
        $sum .= $this->privateKey ; //your private key
        $control_sum = md5($sum);

        return $control_sum;
    }

    public function getFilteredParam($param, $value){

        $filterList = array(
            'cardType'    => "/^[v|m]$/",
            'amount'      => '/^[0-9.]*$/',
            'item'        => '/^[a-zA-Z0-9\.\s\:\-]*$/',
            'lang'        => '/^(az|en|ru)$/',
            'payment_key' => '/^[a-zA-Z0-9\-]*$/'
        );

        $filter = $filterList[$param];

        if (is_null($filter) || !is_string($filter)) {
            echo "Filter for this parameter not found: ".$param;
            exit();
        }

        //$new_param = filter_input(INPUT_POST, $param, FILTER_SANITIZE_STRING);
        $new_param = $value;

        if ($new_param == null) {
            $new_param = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING);
        }


        if (!preg_match($filter, $new_param)){
            echo "Wrong parameter characters: ".$new_param . ' - '.$param;
            exit();
        }

        return $new_param;
    }

    public function addTransaction($order_id, $transaction_id) {
        $result = $this->db->query("
        INSERT INTO `" . DB_PREFIX . "bolkart_order_transaction`
            SET `bolkart_order_id` = '" . (int)$order_id . "', `transaction_id` = '" . $this->db->escape($transaction_id) . "', `date_added` = '".(new DateTime())->format('Y-m-d H:i:s')."'");

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getLocalTransaction($transaction_id) {
        $result = $this->db->query("
			SELECT *
			FROM " . DB_PREFIX . "bolkart_order_transaction
			WHERE transaction_id = '" . $this->db->escape($transaction_id) . "'
		")->row;

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }


    public function getTotal($sum, $taksit) {
        return $sum * $this->rates[ $taksit ] / 100;
    }
}