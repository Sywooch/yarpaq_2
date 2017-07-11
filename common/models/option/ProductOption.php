<?php

namespace common\models\option;


use yii\db\ActiveRecord;

class  ProductOption extends ActiveRecord
{
    public function rules() {
        return [
            [['product_id', 'option_id'], 'required'],
            ['required', 'default', 'value' => 1]
        ];
    }

    public function getOption() {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }

    public function getValues() {
        return $this->hasMany(ProductOptionValue::className(), ['product_option_id' => 'id']);
    }
}