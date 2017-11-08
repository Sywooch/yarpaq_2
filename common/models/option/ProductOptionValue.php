<?php

namespace common\models\option;


use yii\db\ActiveRecord;

class ProductOptionValue extends ActiveRecord
{
    /**
     * Сценарий, при котором не редактируется option_value_id,
     * а только значения 'quantity', 'price_prefix', 'price'
     */
    const SCENARIO_UPDATE = 'update';

    public function rules() {
        return [
            [['product_option_id', 'option_value_id', 'quantity', 'price_prefix', 'price'], 'required'],
            ['price_prefix', 'in', 'range' => ['-', '+']],
            ['price', 'number'],
            [['quantity', 'product_option_id', 'option_value_id'], 'integer']
        ];
    }

    public function getOptionValue() {
        return $this->hasOne(OptionValue::className(), ['id' => 'option_value_id']);
    }

    public function getProductOption() {
        return $this->hasOne(ProductOption::className(), ['id' => 'product_option_id']);
    }

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_UPDATE] = ['quantity', 'price_prefix', 'price'];

        return $scenarios;
    }
}