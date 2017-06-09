<?php

namespace common\models;

use yii\db\ActiveRecord;

class Zone extends ActiveRecord
{
    /**
     * This is the model class for table "{{%zone}}".
     *
     * @property integer $id
     * @property integer $country_id
     * @property string $name
     * @property string $code
     * @property string $status
     */

    public function getCountry() {
        $this->hasOne(Country::className(), ['country_id' => 'id']);
    }
}