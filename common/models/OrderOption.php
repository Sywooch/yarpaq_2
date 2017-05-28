<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_option}}".
 *
 * @property integer $order_option_id
 * @property integer $order_id
 * @property integer $order_product_id
 * @property integer $product_option_id
 * @property integer $product_option_value_id
 * @property string $name
 * @property string $value
 * @property string $type
 */
class OrderOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_product_id', 'product_option_id', 'name', 'value', 'type'], 'required'],
            [['order_id', 'order_product_id', 'product_option_id', 'product_option_value_id'], 'integer'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_option_id' => Yii::t('app', 'Order Option ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'order_product_id' => Yii::t('app', 'Order Product ID'),
            'product_option_id' => Yii::t('app', 'Product Option ID'),
            'product_option_value_id' => Yii::t('app', 'Product Option Value ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
