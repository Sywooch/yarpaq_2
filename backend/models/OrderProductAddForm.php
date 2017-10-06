<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class OrderProductAddForm extends Model
{
    public $product_id;
    public $quantity;
    public $options;

    public function rules() {
        return [
            ['product_id', 'required', 'when' => function ($model) {
                return $model->quantity != '';
            }, 'whenClient' => "function (attribute, value) {
                return $('#orderproductaddform-quantity').val() != '';
            }"],
            ['quantity', 'required', 'when' => function ($model) {
                return $model->product_id != '';
            }, 'whenClient' => "function (attribute, value) {
                return $('#orderproductaddform-product_id').val() != null;
            }"],
            ['quantity', 'integer']
        ];
    }
}