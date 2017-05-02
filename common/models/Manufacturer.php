<?php

namespace common\models;

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

    public $uploadSubDir = 'manufacturers';
    public $image;

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
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],

            [['image'], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg, gif, png'],
            [['image'], 'file', 'maxSize' => 1024 * 1024],

            [['image_src_filename', 'image_web_filename'], 'string', 'max' => 255],
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
            'image_src_filename' => Yii::t('app', 'Filename'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Удаляет файл с диска
     *
     * @return bool
     */
    public function deleteImage()
    {
        return @unlink($this->imagePath);
    }

    public function getImageUrl() {
        return Yii::$app->urlManagerUploads->createUrl(Yii::$app->params['uploadsDir'] . '/' . $this->uploadSubDir . '/' . $this->image_web_filename);
    }

    public function getImagePath() {
        return Yii::$app->params['uploadsPath'] . '/' . $this->uploadSubDir . '/' . $this->image_web_filename;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // delete containing image
            $this->deleteImage();

            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $now = new \DateTime();

            // set Created At
            if ($this->isNewRecord) {
                $this->created_at = $now->format('Y-m-d H:i:s');
            }

            // set Updated At
            $this->updated_at = $now->format('Y-m-d H:i:s');

            return true;
        }

        return false;
    }
}
