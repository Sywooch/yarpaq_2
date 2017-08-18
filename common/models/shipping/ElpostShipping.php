<?php

namespace common\models\shipping;


class ElpostShipping extends Shipping
{
    protected $rates = [
        '12' => '100:0',
        '13' => '100:2'
    ];


}