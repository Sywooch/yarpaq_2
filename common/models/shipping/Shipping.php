<?php

namespace common\models\shipping;

abstract class Shipping
{
    protected $rates;

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