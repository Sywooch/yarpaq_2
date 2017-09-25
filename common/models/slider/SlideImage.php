<?php

namespace common\models\slider;

use Yii;
use common\models\Language;

/**
 * This is the model class for table "{{%slide_image}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $language_id
 * @property string $link
 * @property string $src_name
 * @property string $web_name
 *
 * @property Slide $model
 */
class SlideImage extends \yii\db\ActiveRecord
{

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slide_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', /* 'src_name', 'web_name'*/], 'required'],
            [['model_id', 'language_id'], 'integer'],
            [['link', 'src_name', 'web_name'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Slide::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_id' => Yii::t('app', 'Model ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'link' => Yii::t('app', 'Link'),
            'src_name' => Yii::t('app', 'Src Name'),
            'web_name' => Yii::t('app', 'Web Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Slide::className(), ['id' => 'model_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * Возвращает полные URL до файла
     *
     * @return mixed
     */
    public function getUrl() {
        return Yii::$app->urlManagerMedia->createUrl(Yii::$app->params['slide.uploads.url'] . $this->web_name);
    }

    /**
     * Возвращает полный путь до файла
     *
     * @return string
     */
    public function getPath() {
        return Yii::$app->params['slide.uploads.path'] . $this->web_name;
    }
}
