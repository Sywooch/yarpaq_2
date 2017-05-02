<?php

namespace common\models\option;


use yii\db\ActiveRecord;

class OptionDescription extends ActiveRecord
{
    public function rules() {
        return [
            ['name', 'required']
        ];
    }

    public function getOption() {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }
}