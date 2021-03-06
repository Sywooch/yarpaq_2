<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\models\shipping\AzerpoctShipping;
use common\models\shipping\ElpostShipping;

class ShippingController extends BasicController
{
    public $freeAccessActions = ['calculate'];

    public function actionCalculate($zone_id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $db         = Yii::$app->db;
        $cart       = Yii::$app->cart;
        $currency   = Yii::$app->currency;
        $defaultCurrency = $currency->getCurrencyByCode('AZN');


        // Azerpoct
        $azerpoct = new AzerpoctShipping();
        $geo = $db->createCommand('SELECT geo_zone_id FROM `y2_zone_to_geo_zone` WHERE geo_zone_id IN ('.implode(', ', $azerpoct->getAvailableGeoZones()).') AND zone_id = '.(int)$zone_id)->queryOne();
        if ($geo) {
            $fee = $azerpoct->calculateCost($cart->weight, $geo['geo_zone_id']);

            $response['azerpoct'] = [
                'code'          => 'azerpoct.azerpoct_'.$geo['geo_zone_id'],
                'amount'        => $currency->convertAndFormat($fee, $defaultCurrency),
                'raw_amount'    => $currency->convert($fee, $defaultCurrency)
            ];
        }


        // Elpost
        $elpost= new ElpostShipping();
        $geo = $db->createCommand('SELECT geo_zone_id FROM `y2_zone_to_geo_zone` WHERE geo_zone_id IN ('.implode(', ', $elpost->getAvailableGeoZones()).') AND zone_id = '.(int)$zone_id)->queryOne();
        if ($geo) {
            $fee = $elpost->calculateCost($cart->weight, $geo['geo_zone_id']);

            $response['elpost'] = [
                'code'          => 'elpost.elpost_'.$geo['geo_zone_id'],
                'amount'        => $currency->convertAndFormat($fee, $defaultCurrency),
                'raw_amount'    => $currency->convert($fee, $defaultCurrency)
            ];
        }

        return $response;
    }
}