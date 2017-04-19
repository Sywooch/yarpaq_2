<?php

namespace common\models;

use backend\models\Language;
use Yii;

class StockStatus
{
    public static function getDropDownData() {
        $list = Yii::$app->db->createCommand("SELECT * FROM {{%stock_status}} WHERE `language_id` = ".Language::getCurrent()->id)->queryAll(\PDO::FETCH_OBJ);

        $data = [];
        foreach ($list as $item) {
            $data[ $item->stock_status_id ] = $item->name;
        }

        return $data;
    }
}