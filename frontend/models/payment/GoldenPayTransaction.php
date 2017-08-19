<?php

namespace frontend\models\payment;


use yii\db\ActiveRecord;

class GoldenPayTransaction extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%goldenpay_order_transaction}}';
    }
}