<?php

namespace common\models\order;


use common\models\Language;
use yii\db\ActiveRecord;

class OrderStatus extends ActiveRecord
{
    public static function getData() {
        return self::find()->andWhere(['language_id' => Language::getCurrent()])->all();
    }
}