<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property double $value
 * @property integer $decimal_place
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Currency extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code', 'value', 'status', 'created_at', 'updated_at'], 'required'],
            [['value'], 'number'],
            [['decimal_place', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'code' => Yii::t('app', 'Code'),
            'value' => Yii::t('app', 'Value'),
            'decimal_place' => Yii::t('app', 'Decimal Place'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
