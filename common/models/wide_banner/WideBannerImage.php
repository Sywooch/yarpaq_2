<?php

namespace common\models\wide_banner;

use Yii;
use common\models\Language;

/**
 * This is the model class for table "{{%wide_banner_image}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $language_id
 * @property string $link
 * @property string $src_name
 * @property string $web_name
 *
 * @property WideBanner $model
 */
class WideBannerImage extends \yii\db\ActiveRecord
{

    public $desktopImage;
    public $mobileImage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wide_banner_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'src_name', 'web_name'], 'required'],
            [['desktopImage', 'mobileImage'], 'image', 'skipOnEmpty' => false, 'maxFiles' => 1,
                // не пропускать пустое значение, если:
                'when' => function ($model) {
                    if ($model->src_name != '') {
                        return false;
                    } else {
                        return true;
                    }
                },
                'whenClient' => "function (attribute, value) {
                    return !$(attribute.container).find('.file-preview-thumbnails').children().length;
                }",
            ],
            [['model_id', 'language_id'], 'integer'],
            [['link', 'src_name', 'web_name'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => WideBanner::className(), 'targetAttribute' => ['model_id' => 'id']],
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
        return $this->hasOne(WideBanner::className(), ['id' => 'model_id']);
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

    /**
     * Возвращает полные URL до файла
     *
     * @return mixed
     */
    public function getMbUrl() {
        return Yii::$app->urlManagerMedia->createUrl(Yii::$app->params['slide.uploads.url'] . $this->web_mb_name);
    }

    /**
     * Возвращает полный путь до файла
     *
     * @return string
     */
    public function getMbPath() {
        return Yii::$app->params['slide.uploads.path'] . $this->web_mb_name;
    }

    /**
     * Удаляет файл с диска
     *
     * @return bool
     */
    public function deleteImage() {
        return ( @unlink($this->path) && @unlink($this->mbPath) );
    }
}
