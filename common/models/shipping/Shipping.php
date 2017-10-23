<?php

namespace common\models\shipping;

use common\models\Zone;
use yii\base\Exception;

abstract class Shipping
{
    protected $rates;

    public function calculateCostByZone($weight, Zone $zone) {
        $geo_zones = $zone->geoZones;

        if (isset($geo_zones[0])) {
            return $this->calculateCost($weight, $geo_zones[0]->geo_zone_id);
        } else {
            throw new Exception('Geo Zone not found');
        }
    }

    public function calculateCost($weight, $geo_zone_id) {
        $result = 0;

        if (isset($this->rates[$geo_zone_id])) {
            $rate = $this->rates[$geo_zone_id];
            $pairs = explode(',', $rate);

            $defaultPair = $pairs[0];
            $result = explode(':', $defaultPair)[1];

            foreach (explode(',', $rate) as $pair) {
                $rate_weight    = explode(':', $pair)[0];
                $rate_cost      = explode(':', $pair)[1];

                if ($rate_weight > $weight) {
                    break;
                } else {
                    $result = $rate_cost;
                }
            }
        } else {
            throw new Exception('No rates for Geo Zone ('.$geo_zone_id.')');
        }

        return $result;
    }

    public function getAvailableGeoZones() {
        return array_keys( $this->rates );
    }

    public static function create($shipping_method) {
        if ($shipping_method == 'Azerpoct') {
            return new AzerpoctShipping();
        } else if ($shipping_method == 'Elpost') {
            return new ElpostShipping();
        }
    }
}