<?php

namespace common\models\shipping;

use Yii;

/**
 * This is the model class for table "{{%shipping_method}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 */
class ShippingMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shipping_method}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
        ];
    }
}
