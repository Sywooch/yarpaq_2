<?php

namespace common\models\slider;

use common\behaviors\MetaData;
use common\behaviors\Sortable;
use common\models\Language;
use Yii;

/**
 * This is the model class for table "{{%slide}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $settings
 */
class Slide extends \yii\db\ActiveRecord
{
    public $images;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slide}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'meta-data' => [
                'class' => MetaData::className(),
            ],
            'sortable' => [
                'class' => Sortable::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status', 'created_at'], 'required'],
            [['status', 'sort'], 'integer'],
            ['sort', 'default', 'value' => 'COALESCE((MAX(sort) + 1)'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'settings'], 'string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'settings' => Yii::t('app', 'Settings'),
        ];
    }

    public function getContents() {
        return $this->hasMany(SlideImage::className(), ['model_id' => 'id']);
    }

    public function getContent() {
        return $this->hasOne(SlideImage::className(), ['model_id' => 'id'])->andWhere(['language_id' => Language::getCurrent()->id]);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $contents = $this->contents;
            foreach ($contents as $content) {
                $content->deleteImage();
            }

            return true;
        } else {
            return false;
        }
    }

}
