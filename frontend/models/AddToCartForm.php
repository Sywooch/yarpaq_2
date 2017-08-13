<?php

namespace frontend\models;

use Yii;
use common\models\Product;
use yii\base\Model;

class AddToCartForm extends Model
{
    public $productId;
    public $quantity;
    public $productOptionValues;

    public function rules() {
        return [
            [['productId', 'quantity'], 'required'],
            ['productId', 'validateProduct'],
        ];
    }

    public function validateProduct($attribute, $params, $validator) {
        $product = Product::findOne($this->productId);

        if (!$product) {
            $this->addError($attribute, Yii::t('app', 'Product not found'));
        } else {
            if ($product->quantity < $this->quantity) {
                $this->addError($attribute, Yii::t('app', 'Product in such quantity is not available'));
            }
        }
    }
}