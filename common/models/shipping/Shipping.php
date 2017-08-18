<?php

namespace common\models\shipping;


use common\models\Zone;

abstract class Shipping
{
    protected $rates;

    public function calculateCost($weight, Zone $zone) {

    }

    public function getAvailableGeoZones() {
        return array_keys( $this->rates );
    }

}