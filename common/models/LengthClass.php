<?php

namespace common\models;

use common\models\Language;
use Yii;

class LengthClass
{
    public static function getDropDownData() {
        $sql = "SELECT * FROM {{%length_class}} w LEFT JOIN {{%length_class_content}} wd ON wd.length_class_id = w.id WHERE wd.`language_id` = ".Language::getCurrent()->id;

        $list = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_OBJ);

        $data = [];
        foreach ($list as $item) {
            $data[ $item->id ] = $item->title;
        }

        return $data;
    }
}