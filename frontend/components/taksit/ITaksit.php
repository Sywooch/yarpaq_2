<?php

namespace frontend\components\taksit;

interface ITaksit
{
    public function getMonthlyAmount($months);
    public function getTotalAmount($months);
    public function getMonths();
}