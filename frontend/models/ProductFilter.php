<?php

namespace frontend\models;

use common\models\Product;
use Yii;
use yii\base\Model;

class ProductFilter extends Model
{

    const SORT_PRICE_LOWEST = 'price_lowest';

    public $condition = Product::CONDITION_NEW;
    public $brand = [];
    public $price_from;
    public $price_to;

    public $price_min;
    public $price_max;

    public $per_page;
    public $sort = self::SORT_PRICE_LOWEST;

    public function rules() {
        return [
            [['condition', 'per_page'], 'integer'],
            [['price_from', 'price_to'], 'number'],
            ['brand', 'each', 'rule' => ['integer']],
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

    public function hasBrand($brand_id) {
        return in_array($brand_id, $this->brand);
    }
}