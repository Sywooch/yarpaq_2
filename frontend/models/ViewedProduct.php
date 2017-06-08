<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class ViewedProduct extends ActiveRecord
{
    public function rules() {
        return [
            [['product_id', 'user_id'], 'required'],
            [['product_id', 'user_id'], 'integer']
        ];
    }

    public static function log($product_id) {

        $user = Yii::$app->user->identity;

        if ($user) {
            $view               = new ViewedProduct();
            $view->product_id   = $product_id;
            $view->user_id      = $user->id;
            $view->created_at   = (new \DateTime())->format('Y-m-d H:i:s');

            $view->save();
        }

    }
}