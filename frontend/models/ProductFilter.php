<?php

namespace frontend\models;

use common\models\Product;
use Yii;
use yii\base\Model;

class ProductFilter extends Model
{

    const SORT_PRICE_LOWEST = 'price_lowest';
    const SORT_PRICE_HIGHEST = 'price_highest';
    const SORT_NEWLY_LISTED = 'newly_listed';


    public $condition = Product::CONDITION_NEW;
    public $brand = [];
    public $price_from;
    public $price_to;

    public $price_min;
    public $price_max;

    public $per_page;
    public $sort = self::SORT_NEWLY_LISTED;
    public $optionValues = [];

    public function rules() {
        return [
            [['condition', 'per_page'], 'integer'],
            [['price_from', 'price_to'], 'number'],
            [['brand', 'optionValues'], 'each', 'rule' => ['integer']],
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
            self::SORT_PRICE_LOWEST     => Yii::t('app', 'Price: lowest first'),
            self::SORT_PRICE_HIGHEST    => Yii::t('app', 'Price: highest first'),
            self::SORT_NEWLY_LISTED     => Yii::t('app', 'Newly listed'),
        ];
    }

    public function getSortSetting() {
        $settings = [
            self::SORT_PRICE_LOWEST     => [Product::tableName().'.price' => SORT_ASC],
            self::SORT_PRICE_HIGHEST    => [Product::tableName().'.price' => SORT_DESC],
            self::SORT_NEWLY_LISTED     => [Product::tableName().'.moderated_at' => SORT_DESC],
        ];

        if (isset($settings[$this->sort])) {
            return $settings[$this->sort];
        }

        return [];
    }

    public function getPerPageOptions() {
        return [24, 48];
    }

    /**
     * Индикатор выбранного Производителя в фильтре
     * Используется для включения галочек в фильтре
     *
     * @param $brand_id
     * @return bool
     */
    public function hasBrand($brand_id) {
        return in_array($brand_id, $this->brand);
    }


    /**
     * Индикатор выбранного Значения Опции в фильтре (S, M, ... )
     * Используется для включения галочек в фильтре
     *
     * @param $optionValueID
     * @return bool
     */
    public function hasOptionValue($optionValueID) {
        return in_array($optionValueID, $this->optionValues);
    }
}