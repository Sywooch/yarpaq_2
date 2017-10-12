<?php

namespace frontend\components\taksit;

/**
 * Class Bolkart
 *
 * @inheritDoc
 */
class Bolkart extends Taksit
{
    protected $rates = [
        '1' => 5,
        '3' => 9,
        '6' => 13,
    ];
}