<?php

namespace common\models;

use common\models\geo_zone\GeoZone;
use common\models\geo_zone\ZoneToGeoZone;
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
        return $this->hasOne(Country::className(), ['country_id' => 'id']);
    }

    public function getZonesToGeoZones() {
        return $this->hasMany(ZoneToGeoZone::className(), ['zone_id' => 'id']);
    }

    public function getGeoZones() {
        return $this->hasMany(GeoZone::className(), ['geo_zone_id' => 'geo_zone_id'])
            ->via('zonesToGeoZones');
    }
}