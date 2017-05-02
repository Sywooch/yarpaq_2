<?php

namespace common\models;

use common\models\Language;
use Yii;

class WeightClass
{
    public static function getDropDownData() {
        $sql = "SELECT * FROM {{%weight_class}} w LEFT JOIN {{%weight_class_content}} wd ON wd.weight_class_id = w.id WHERE wd.`language_id` = ".Language::getCurrent()->id;

        $list = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_OBJ);

        $data = [];
        foreach ($list as $item) {
            $data[ $item->id ] = $item->title;
        }

        return $data;
    }
}