<?php

namespace common\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;

class Sortable extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'setDefaultSort'
        ];
    }

    public function setDefaultSort() {

        $query = $this->owner->db
            ->createCommand('SELECT MAX(sort) as sort FROM '.$this->owner->tableName())
            ->queryAll();

        $sort = $query[0]['sort'];

        $this->owner->sort = $sort + 1;
    }
}