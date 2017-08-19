<?php

namespace frontend\models\payment;

class AlbaliPayment extends Payment {

    private $urlGetPaymentKey = 'https://pay.millikart.az/gateway/payment/register';
    private $urlGetPaymentResult = 'https://pay.millikart.az/gateway/payment/status';

    private $merchantName = 'yarpaq';
    private $authKey = 'DA151WME4S86EQM4OZHET9T0Z63MKTOM';

    protected $moduleName = 'millikart';

    protected $rates = [
        '1' => 2.6,
        '3' => 5.1,
        '6' => 9,
        //'12' => 16
    ];

    private function getRequest($url, $params) {
        return file_get_contents($url . '?' . http_build_query($params), false);
    }

    public function getPaymentKeyJSONRequest($taksit, $amount, $language, $reference, $description, $currency = 944) {
        $this->merchantName = $this->getMerchantByTaksit($taksit);

        $params['mid'] = $this->merchantName;
        $params['amount'] = $amount;
        $params['currency'] = $currency;
        $params['reference'] = $reference;
        $params['description'] = $description;
        $params['language'] = $language;
        $params['signature'] = $this->getHashcCode($amount, $language, $reference, $description, $currency);

        $response = $this->getRequest($this->urlGetPaymentKey, $params);

        $respObject = simplexml_load_string($response);

        return $respObject;
    }


    public function getPaymentResult($reference, $mid) {
        $params = array(
            'mid' => $mid,
            'reference' => $reference
        );

        $response = file_get_contents($this->urlGetPaymentResult."?".http_build_query($params), false);
        $respObject = simplexml_load_string($response);

        return $respObject;

        //$this->log('Millikart GetPaymentResult ('.date('d.m.Y H:i:s').')'.PHP_EOL . $response);
    }

    private function getHashcCode($amount, $language, $reference, $description = '', $currency) {
        $signature = '';

        $signature .= strlen($this->merchantName) . $this->merchantName;
        $signature .= strlen($amount) . $amount;
        $signature .= strlen($currency) . $currency;
        $signature .= (!empty($description)? strlen($description).$description :"0");
        $signature .= strlen($reference).$reference;
        $signature .= strlen($language).$language;
        $signature .= $this->authKey;

        return strtoupper(md5($signature));
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

    public function getMerchantByTaksit($taksit) {
        switch ($taksit) {
            case '1':
                return 'yarpaq_1';
                break;
            case '3':
                return 'yarpaq_3';
                break;
            case '6':
                return 'yarpaq_6';
                break;
            // case '12':
            //     $this->merchantName = 'yarpaq_12';
            //     break;
        }
    }

    public function getTotal($sum, $taksit) {
        return $sum * $this->rates[ $taksit ] / 100;
    }
}