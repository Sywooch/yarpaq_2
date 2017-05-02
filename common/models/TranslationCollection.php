<?php

namespace common\models;
use Yii;


class TranslationCollection
{

    public function __construct($modelName) {

    }

    private $_items = [];

    public function load($params) {
        $input = $params[$this->getModelName()];


    }

    public function save() {
        $db = Yii::$app->getDb();

        $transaction = $db->getTransaction();

        foreach ($this->_items as $item) {
            $item->save();
        }

        $transaction->commit();

    }

    private function getModelName() {
        return mb_substr(get_class($this), mb_strlen('Collection'));
    }
}