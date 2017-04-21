<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_image}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $src_name
 * @property string $web_name
 * @property integer $sort
 */
class ProductImage extends \yii\db\ActiveRecord
{
    protected $dir = 'product';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'src_name', 'web_name', 'sort'], 'required'],
            [['model_id', 'sort'], 'integer'],
            [['src_name', 'web_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_id' => Yii::t('app', 'Product ID'),
            'src_name' => Yii::t('app', 'Src Name'),
            'web_name' => Yii::t('app', 'Web Name'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }


    /**
     * Возвращает полные URL до файла
     *
     * @return mixed
     */
    public function getUrl() {
        return Yii::$app->urlManagerUploads->createUrl(Yii::$app->params['product.uploads.url'] . $this->web_name);
    }


    /**
     * Возвращает полный путь до файла
     *
     * @return string
     */
    public function getPath() {
        return Yii::$app->params['product.uploads.path'] . $this->web_name;
    }

    /**
     * Удаляет файл с диска
     *
     * @return bool
     */
    public function deleteImage() {
        return @unlink($this->path);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $this->deleteImage();

            return true;
        } else {
            return false;
        }
    }
}
