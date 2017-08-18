<?php

namespace common\models\shipping;


class AzerpoctShipping extends Shipping
{
    protected $rates = [
        '5' => '2:3,5:4.20,10:10,30:15.50,50:18.50,999:25.50'
    ];
}