<?php

namespace common\models;

use common\models\category\Category;
use common\models\option\Option;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\review\Review;
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
    const SCENARIO_SELLER   = 'seller';

    const CONDITION_NEW     = 1;
    const CONDITION_USED    = 2;

    protected $conditions = [
        '1' => 'New',
        '2' => 'Used'
    ];

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
            [['title', 'description', 'model', 'condition_id', 'price', 'currency_id', 'quantity', 'location_id', 'weight', 'user_id'], 'required'],
            [['condition_id', 'currency_id', 'quantity', 'stock_status_id', 'weight_class_id', 'length_class_id', 'status_id', 'user_id', 'location_id', 'manufacturer_id', 'viewed', 'moderated'], 'integer'],
            ['status_id',       'default', 'value' => self::STATUS_ACTIVE],
            ['viewed',          'default', 'value' => 0],
            ['weight_class_id', 'default', 'value' => 1],
            ['length_class_id', 'default', 'value' => 1],
            ['moderated',       'default', 'value' => 0],
            ['galleryFiles', 'image', 'skipOnEmpty' => false, 'maxFiles' => 10,
                // не пропускать пустое значение, если:
                'when' => function ($model) {
                    if ($model->scenario == 'import') {
                        return true;
                    } else if (count($model->gallery) == 0) {
                        return false;
                    }
                },
                'whenClient' => "function (attribute, value) {
                    return $('input[name=\"gallery_sort\"]').val() == '';
                }",
            ],

            [['price'], 'number'],
            [['weight', 'length', 'width', 'height'], 'number'],
            [['title', 'model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn'], 'string', 'max' => 255],
            ['categoryIDs', 'each', 'rule' => ['integer']],

        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_IMPORT] = [];
        $scenarios[self::SCENARIO_SELLER] = [
            'title',
            'description',
            'model',
            'sku',
            'upc',
            'ean',
            'jan',
            'isbn',
            'mpn',
            'location_id',
            'condition_id',
            'price',
            'currency_id',
            'quantity',
            'stock_status_id',
            'weight',
            '!weight_class_id',
            'length', 'width', 'height',
            '!length_class_id',
            '!status_id',
            '!user_id',
            'manufacturer_id',
            '!viewed',
            '!moderated',

            'categoryIDs',
            'galleryFiles'
        ];

        return $scenarios;
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
            'description' => Yii::t('app', 'Description'),
            'galleryFiles' => Yii::t('app', 'Gallery Files'),
            'categoryIDs' => Yii::t('app', 'Category'),
            'title' => Yii::t('app', 'Title'),
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

    /**
     * @return $this ActiveQuery
     */
    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('{{%product_category}}', ['product_id' => 'id']);
    }

    public function getCategory() {
        return $this->getCategories()->limit(1);
    }

    public function getOptions() {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])->via('productOptions');
    }

    public function getProductOptions() {
        return $this->hasMany(ProductOption::className(), ['product_id' => 'id']);
    }

    public function getManufacturer() {
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer_id']);
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

        if ($considerOptions && $this->appliedOptions) {
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

        if ($this->appliedOptions) {
            foreach ($this->appliedOptions as $appliedOption) {
                $productOption = $appliedOption['product_option'];
                $productOptionValue = $appliedOption['product_option_value'];

                $name = $productOption->option->content->name;
                $value = $productOptionValue->optionValue->content->name;

                $title .= ' &mdash; <small>'.$name.': '.$value.'</small>';
            }
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

    public function getCondition() {
        return $this->conditions[$this->condition_id];
    }

    public function getLocation() {
        return $this->hasOne(Zone::className(), ['id' => 'location_id']);
    }

    public function hasDiscount() { // TODO
        return false;
    }

    public function getDiscount() { // TODO
        return 3;
    }

    public function getRating() { // TODO
        return 4;
    }

    public function getOldPrice() { // TODO
        return $this->price + 3;
    }

    public function getPreview() {
        if (count($this->gallery)) {
            return $this->gallery[0]->url;
        } else {
            return '#';
        }
    }

    public function getReviews() {
        return $this->hasMany(Review::className(), ['product_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $now = new \DateTime();

            // set Created At
            if ($this->isNewRecord) {
                $this->created_at = $now->format('Y-m-d H:i:s');
            } else {
                // set Updated At
                $this->updated_at = $now->format('Y-m-d H:i:s');
            }

            return true;
        }

        return false;
    }
}
