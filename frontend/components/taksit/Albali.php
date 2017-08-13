<?php

namespace frontend\components\taksit;

/**
 * Class Albali
 *
 * Расчитывает ежемесячную выплату и суммарную выплату на основе цены и количества месяцев
 */
class Albali extends Taksit
{
    protected $rates = [
        '1' => 2.6,
        '3' => 5.1,
        '6' => 9,
    ];
}