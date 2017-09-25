<?php

namespace common\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;

class MetaData extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'updateMetaData'
        ];
    }

    public function updateMetaData() {
        $now = new \DateTime();
        $formatted = $now->format('Y-m-d H:i:s');

        // set Created At
        if ($this->owner->isNewRecord) {
            $this->owner->created_at = $formatted;
        } else {
            // set Updated At
            $this->owner->updated_at = $formatted;
        }
    }
}