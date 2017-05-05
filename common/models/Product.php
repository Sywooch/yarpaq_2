<?php

namespace common\models;

use common\models\option\ProductOption;
use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property string $model
 * @property string $sku
 * @property string $upc
 * @property string $ean
 * @property string $jan
 * @property string $isbn
 * @property string $mpn
 * @property string $location_id
 * @property integer $condition_id
 * @property string $price
 * @property integer $currency_id
 * @property integer $quantity
 * @property integer $stock_status_id
 * @property string $weight
 * @property integer $weight_class_id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $length_class_id
 * @property integer $status_id
 * @property integer $user_id
 * @property integer $manufacturer_id
 * @property integer $viewed
 * @property integer $moderated
 * @property string $moderated_at
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends \yii\db\ActiveRecord
{

    public $galleryFiles;

    const SCENARIO_IMPORT   = 'import';
    const SCENARIO_DEFAULT  = 'default';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'model', 'condition_id', 'price', 'currency_id', 'quantity', 'location_id', 'weight'], 'required'],
            [['condition_id', 'currency_id', 'quantity', 'stock_status_id', 'weight_class_id', 'length_class_id', 'status_id', 'user_id', 'location_id', 'manufacturer_id', 'viewed', 'moderated'], 'integer'],
            ['weight_class_id', 'default', 'value' => 1],
            ['length_class_id', 'default', 'value' => 1],
            ['moderated', 'default', 'value' => 1],
            ['galleryFiles', 'image', 'skipOnEmpty' => false, 'maxFiles' => 10,
                'when' => function ($model) {
                    return !count($model->gallery) || $model->scenarion != 'import';
                },
                'whenClient' => "function (attribute, value) {
                    return $('input[name=\"gallery_sort\"]').val() == '';
                }"
            ],

            [['price'], 'number'],
            [['weight', 'length', 'width', 'height'], 'number'],
            [['moderated_at', 'created_at', 'updated_at'], 'safe'],
            [['title', 'model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'sku' => Yii::t('app', 'SKU'),
            'upc' => Yii::t('app', 'UPC'),
            'ean' => Yii::t('app', 'EAN'),
            'jan' => Yii::t('app', 'JAN'),
            'isbn' => Yii::t('app', 'ISBN'),
            'mpn' => Yii::t('app', 'MPN'),
            'location_id' => Yii::t('app', 'Location'),
            'condition_id' => Yii::t('app', 'Condition'),
            'price' => Yii::t('app', 'Price'),
            'currency_id' => Yii::t('app', 'Currency'),
            'quantity' => Yii::t('app', 'Quantity'),
            'galleryField' => Yii::t('app', 'Images & Video'),
            'stock_status_id' => Yii::t('app', 'Stock Status'),
            'weight' => Yii::t('app', 'Weight (kg)'),
            'weight_class_id' => Yii::t('app', 'Weight Class'),
            'length' => Yii::t('app', 'Length (sm)'),
            'width' => Yii::t('app', 'Width (sm)'),
            'height' => Yii::t('app', 'Height (sm)'),
            'length_class_id' => Yii::t('app', 'Length Class'),
            'status_id' => Yii::t('app', 'Status'),
            'user_id' => Yii::t('app', 'User'),
            'manufacturer_id' => Yii::t('app', 'Manufacturer'),
            'viewed' => Yii::t('app', 'Viewed'),
            'moderated' => Yii::t('app', 'Moderated'),
            'moderated_at' => Yii::t('app', 'Moderated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function getGallery() {
        return $this->hasMany(ProductImage::className(), ['model_id' => 'id'])->orderBy('sort');
    }

    public function getStatus() {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    public function getSeller() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_IMPORT] = [];

        return $scenarios;
    }

    public function getOptions() {
        return $this->hasMany(ProductOption::className(), ['product_id' => 'id']);
    }
}
