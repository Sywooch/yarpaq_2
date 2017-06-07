<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class ProductFilter extends Model
{
    public $condition;
    public $brand;
    public $price_from;
    public $price_to;

    public $price_min;
    public $price_max;

    public $per_page;
    public $sort;

    public function rules() {
        return [
            [['condition', 'brand', 'price_from', 'price_to', 'per_page'], 'integer'],
            ['sort', 'sortOptionValidator']
        ];
    }

    public function sortOptionValidator($attribute, $params, $validator)
    {
        if (!isset($this->getSortOptions()[$this->$attribute])) {
            $this->addError($attribute, 'Unknown sort');
        }
    }



    public function getSortOptions() {
        return [
            'price_lowest'  => Yii::t('app', 'Price: lowest first'),
            'price_highest' => Yii::t('app', 'Price: highest first')
        ];
    }

    public function getSortSetting() {
        $settings = [
            'price_lowest'  => ['price' => SORT_ASC],
            'price_highest' => ['price' => SORT_DESC]
        ];

        return $settings[$this->sort];
    }

    public function getPerPageOptions() {
        return [24, 48];
    }
}