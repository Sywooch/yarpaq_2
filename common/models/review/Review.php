<?php

namespace common\models\review;

use common\models\User;
use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    public function rules() {
        return [
            [['customer_id', 'seller_id', 'product_id', 'post_date', 'stars'], 'required'],
            [['customer_id', 'seller_id', 'product_id', 'stars'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE]
        ];
    }

    public function getCustomer() {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    public function activate() {
        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }

    public function deactivate() {
        $this->status = self::STATUS_INACTIVE;
        return $this->save();
    }
}