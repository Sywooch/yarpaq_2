<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $template_id
 * @property string $name
 * @property integer $status
 * @property string $modified
 * @property integer $modified_user_id
 * @property string $created
 * @property integer $created_user_id
 * @property string $published
 * @property integer $sort
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'template_id', 'name', 'status', 'modified', 'modified_user_id', 'created', 'created_user_id', 'sort'], 'required'],
            [['parent_id', 'template_id', 'status', 'modified_user_id', 'created_user_id', 'sort'], 'integer'],
            [['modified', 'created', 'published'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'template_id' => Yii::t('app', 'Template ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'modified' => Yii::t('app', 'Modified'),
            'modified_user_id' => Yii::t('app', 'Modified User ID'),
            'created' => Yii::t('app', 'Created'),
            'created_user_id' => Yii::t('app', 'Created User ID'),
            'published' => Yii::t('app', 'Published'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
}
