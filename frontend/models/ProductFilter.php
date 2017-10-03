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
            self::SORT_PRICE_LOWEST     => Yii::t('app', 'Price: lowest first'),
            self::SORT_PRICE_HIGHEST    => Yii::t('app', 'Price: highest first'),
            self::SORT_NEWLY_LISTED     => Yii::t('app', 'Newly listed'),
        ];
    }

    public function getSortSetting() {
        $settings = [
            self::SORT_PRICE_LOWEST     => ['price' => SORT_ASC],
            self::SORT_PRICE_HIGHEST    => ['price' => SORT_DESC],
            self::SORT_NEWLY_LISTED     => ['moderated_at' => SORT_DESC],
        ];

        if (isset($settings[$this->sort])) {
            return $settings[$this->sort];
        }

        return [];
    }

    public function getPerPageOptions() {
        return [24, 48];
    }

    public function hasBrand($brand_id) {
        return in_array($brand_id, $this->brand);
    }
}