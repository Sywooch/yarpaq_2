<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%manufacturer}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manufacturer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'image'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255],
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
            'image' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
