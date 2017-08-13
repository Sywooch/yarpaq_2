<?php

namespace frontend\components\taksit;


/**
 * Расчитывает ежемесячную выплату и суммарную выплату на основе цены и количества месяцев
 *
 * @package frontend\components\taksit
 */
abstract class Taksit implements ITaksit
{
    protected $price;
    protected $rates = [];

    public function __construct($price) {
        $this->price    = (double) $price;
    }

    public function getMonthlyAmount($months) {
        $amount = $this->price / 100 * ($this->rates[$months]+100) / $months;
        return round($amount * 100) / 100;
    }

    public function getTotalAmount($months) {
        return $this->getMonthlyAmount($months) * $months;
    }

    public function getMonths() {
        return array_keys($this->rates);
    }
}