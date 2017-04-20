<?php

namespace common\models;

use yii\db\ActiveRecord;

class Zone extends ActiveRecord
{
    public function getCountry() {
        $this->hasOne(Country::className(), ['country_id' => 'id']);
    }
}