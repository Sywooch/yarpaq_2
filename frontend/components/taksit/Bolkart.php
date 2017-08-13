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
        '1' => 1.8,
        '3' => 5.8,
        '6' => 9.8,
    ];
}