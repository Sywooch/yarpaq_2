<?php

namespace common\models\option;


use yii\db\ActiveRecord;

class ProductOptionValue extends ActiveRecord
{
    public function getOptionValue() {
        return $this->hasOne(OptionValue::className(), ['id' => 'option_value_id']);
    }
}