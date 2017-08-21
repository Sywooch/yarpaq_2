<?php

namespace common\models\review;

use common\models\User;

class Review extends \yii\db\ActiveRecord
{
    public function getCustomer() {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }
}