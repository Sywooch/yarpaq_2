<?php

namespace common\models;

use common\models\category\Category;
use common\models\option\Option;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use Faker\Provider\DateTime;
use Yii;
use yii\helpers\ArrayHelper;

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
    public $categoryIDs = [];

    const STATUS_INACTIVE   = 0;
    const STATUS_ACTIVE     = 1;

    const SCENARIO_IMPORT   = 'import';
    const SCENARIO_DEFAULT  = 'default';

    protected $appliedOptions;

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
                // не пропускать пустое значение, если:
                'when' => function ($model) {
                    // в галерее 0 картинок или сценарий НЕ ИМПОРТ
                    return count($model->gallery) == 0 || $model->scenario != 'import';
                },
                'whenClient' => "function (attribute, value) {
                    return $('input[name=\"gallery_sort\"]').val() == '';
                }"
            ],

            [['price'], 'number'],
            [['weight', 'length', 'width', 'height'], 'number'],
            [['moderated_at', 'created_at', 'updated_at'], 'safe'],
            [['title', 'model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn'], 'string', 'max' => 255],
            ['categoryIDs', 'each', 'rule' => ['integer']]
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

    public function afterFind() {
        parent::afterFind();

        $this->categoryIDs = ArrayHelper::map($this->categories, 'id', 'id');
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        ProductCategory::saveProductCategories($this->categoryIDs, $this->id);
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

    public function getCurrency() {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getProductCategories() {
        return $this->hasMany(ProductCategory::className(), ['product_id' => 'id']);
    }

    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('{{%product_category}}', ['product_id' => 'id']);
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_IMPORT] = [];

        return $scenarios;
    }

    public function getOptions() {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])->via('productOptions');
    }

    public function getProductOptions() {
        return $this->hasMany(ProductOption::className(), ['product_id' => 'id']);
    }

    /**
     * Применить опцию (со значением) к товару
     *
     * @param ProductOption $productOption
     * @param ProductOptionValue $productOptionValue
     */
    public function applyOption(ProductOption $productOption, ProductOptionValue $productOptionValue) {
        $this->appliedOptions[] = [
            'product_option'        => $productOption,
            'product_option_value'  => $productOptionValue
        ];
    }

    /**
     * Возвращает примененные опции к товару
     *
     * @return mixed
     */
    public function getAppliedOptions() {
        return $this->appliedOptions;
    }

    /**
     * Получение цены.
     * Получение базовой цены либо с учетом опций.
     * Чтобы учитывать опции их сначало надо применить к товару.
     *
     * @param bool|false $considerOptions Флаг - учитывай примененные опции или нет.
     * @return string
     */
    public function getPrice($considerOptions = false) {
        $price = $this->price;

        if ($considerOptions) {
            foreach ($this->appliedOptions as $appliedOption) {
                $productOptionValue = $appliedOption['product_option_value'];

                if ($productOptionValue->price_prefix == '-') {
                    $price -= $productOptionValue->price;
                } else {
                    $price += $productOptionValue->price;
                }
            }
        }

        return $price;
    }

    public function getTitleWithOptions() {
        $title = $this->title;

        foreach ($this->appliedOptions as $appliedOption) {
            $productOption = $appliedOption['product_option'];
            $productOptionValue = $appliedOption['product_option_value'];

            $name = $productOption->option->content->name;
            $value = $productOptionValue->optionValue->content->name;

            $title .= ' &mdash; <small>'.$name.': '.$value.'</small>';
        }

        return $title;
    }

    /**
     * Отвечает на вопрос является ли товар новым
     *
     * @return bool
     */
    public function isNew() {
        $month_ago = (new \DateTime())->modify('-1 month');
        return (new \DateTime($this->moderated_at)) >= $month_ago;
    }

    public function getUrl() {
        return Language::getCurrent()->urlPrefix.'/product-'.$this->id;
    }

}
