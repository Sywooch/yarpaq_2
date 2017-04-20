<?php

namespace common\models;

class Country extends \yii\db\ActiveRecord {


    public function getZones() {
        return $this->hasMany(Zone::className(), ['country_id' => 'id']);
    }
}