<?php

namespace frontend\models\payment;


use yii\db\ActiveRecord;

class GoldenPayTransaction extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%goldenpay_order_transaction}}';
    }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert))
        {
            $now = new \DateTime();

            // set Created At
            if (!$this->isNewRecord) {
                $this->date_added = $now->format('Y-m-d H:i:s');
            }

            return true;
        }

        return false;
    }
}