<?php

namespace common\models\search;

use Yii;

class SearchLog extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {


            // set Created At
            if ($this->isNewRecord) {
                $now = new \DateTime();
                $this->created_at = $now->format('Y-m-d H:i:s');
            }

            $this->ip = Yii::$app->request->userIP;
            $this->user_agent = Yii::$app->request->userAgent;

            return true;
        }

        return false;
    }
}