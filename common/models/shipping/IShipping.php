<?php

namespace common\models\shipping;


use common\models\Zone;

interface IShipping
{
    public function calculateCost($weight, Zone $zone);
}