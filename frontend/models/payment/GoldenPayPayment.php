<?php

namespace frontend\models\payment;

class GoldenPayPayment extends Payment {

    private $urlGetPaymentKey    = "https://rest.goldenpay.az/web/service/merchant/getPaymentKey";
    private $urlGetPaymentResult = "https://rest.goldenpay.az/web/service/merchant/getPaymentResult";
    private $urlRedirect         = "https://rest.goldenpay.az/web/paypage?payment_key=";
    private $merchantName   = 'yarpaq';
    private $authKey        = '0533c59493794c17add0ddb21f23760a';

    public $cardType;
    public $amount;
    public $description;
    public $lang;

    protected $moduleName = 'goldenpay';

    public function getPaymentKeyJSONRequest() {

        $params = array(
            'merchantName'  => $this->merchantName,
            'cardType'      => $this->cardType,
            'amount'        => $this->amount,
            'description'   => $this->description
        );

        $params['hashCode'] = $this->getHashcCode($params);
        $params['lang'] = $this->getLang();

        $request = json_encode($params);

        $json = json_decode($this->getJsonContent($this->urlGetPaymentKey, $request));

        $json->urlRedirect = $this->urlRedirect . $json->paymentKey;

        return $json;
    }

    public function getLang() {
        if ($this->lang == 'az') {
            return 'lv';
        } else {
            return $this->lang;
        }
    }

    public function getPaymentResult($payment_key) {
        $params = array(
            'payment_key' => $payment_key
        );
        $params['hash_code'] = $this->getHashcCode($params);

        $options = array(
            'http' => array(
                'header'  => "Accept: application/json\r\n",
                'method'  => 'GET'
            )
        );

        $context = stream_context_create($options);
        $json = file_get_contents($this->urlGetPaymentResult."?".http_build_query($params), false, $context);

        $this->log('GoldenPay GetPaymentResult ('.date('d.m.Y H:i:s').')'.PHP_EOL.$json);

        return json_decode($json);
    }


    private function getHashcCode($params) {
        return md5($this->authKey.implode($params));
    }

    private function getJsonContent($url, $content) {
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\nAccept: application/json\r\n",
                'method'  => 'POST',
                'content' => $content
            ),
        );
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    public function validate() {

        if (!preg_match("/^[v|m]$/", $this->cardType)) { return false; }
        if (!preg_match("/^[0-9.]*$/", $this->amount)) { return false; }
        if (!preg_match('/^(lv|en|ru)$/', $this->getLang())) { return false; }

        return true;
    }

    public function addTransaction($order_id, $transaction_id) {
        $result = $this->db->query("
        INSERT INTO `" . DB_PREFIX . "goldenpay_order_transaction`
            SET `goldenpay_order_id` = '" . (int)$order_id . "', `transaction_id` = '" . $this->db->escape($transaction_id) . "', `date_added` = '".(new DateTime())->format('Y-m-d H:i:s')."'");

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getLocalTransaction($transaction_id) {
        $result = $this->db->query("
			SELECT *
			FROM " . DB_PREFIX . "goldenpay_order_transaction
			WHERE transaction_id = '" . $this->db->escape($transaction_id) . "'
		")->row;

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}