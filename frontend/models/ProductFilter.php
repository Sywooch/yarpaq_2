<?php

namespace frontend\models;


use yii\base\Model;

class ProductFilter extends Model
{
    public $condition;
    public $brand;
    public $price_from;
    public $price_to;


    public function rules() {
        return [
            [['condition', 'brand', 'price_from', 'price_to'], 'integer'],
        ];
    }
}