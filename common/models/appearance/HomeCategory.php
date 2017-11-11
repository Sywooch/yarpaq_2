<?php

namespace common\models\appearance;

use Yii;
use common\models\Product;
use common\models\category\Category;

/**
 * This is the model class for table "{{%home_category}}".
 *
 * @property integer $id
 * @property integer $related_cat_id
 * @property integer $product_id_1
 * @property string $web_name_1
 * @property string $src_name_1
 * @property integer $product_id_2
 * @property string $web_name_2
 * @property string $src_name_2
 * @property integer $product_id_3
 * @property string $web_name_3
 * @property string $src_name_3
 *
 * @property Product $productId1
 * @property Product $productId2
 * @property Product $productId3
 * @property Category $relatedCat
 */
class HomeCategory extends \yii\db\ActiveRecord
{

    public $image1;
    public $image2;
    public $image3;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['image1', 'image', 'skipOnEmpty' => false, 'maxFiles' => 1,
                // не пропускать пустое значение, если:
                'when' => function ($model) {
                    if ($model->src_name_1 != '') {
                        return false;
                    } else {
                        return true;
                    }
                },
                'whenClient' => "function (attribute, value) {
                    return !$(attribute.container).find('.file-preview-thumbnails').children().length;
                }",
            ],
            ['image2', 'image', 'skipOnEmpty' => false, 'maxFiles' => 1,
                // не пропускать пустое значение, если:
                'when' => function ($model) {
                    if ($model->src_name_2 != '') {
                        return false;
                    } else {
                        return true;
                    }
                },
                'whenClient' => "function (attribute, value) {
                    return !$(attribute.container).find('.file-preview-thumbnails').children().length;
                }",
            ],
            ['image3', 'image', 'skipOnEmpty' => false, 'maxFiles' => 1,
                // не пропускать пустое значение, если:
                'when' => function ($model) {
                    if ($model->src_name_3 != '') {
                        return false;
                    } else {
                        return true;
                    }
                },
                'whenClient' => "function (attribute, value) {
                    return !$(attribute.container).find('.file-preview-thumbnails').children().length;
                }",
            ],
            [['status', 'related_cat_id', 'product_id_1', 'web_name_1', 'src_name_1', 'product_id_2', 'web_name_2', 'src_name_2', 'product_id_3', 'web_name_3', 'src_name_3'], 'required'],
            [['status', 'related_cat_id', 'product_id_1', 'product_id_2', 'product_id_3'], 'integer'],
            [['bg_color', 'web_name_1', 'src_name_1', 'web_name_2', 'src_name_2', 'web_name_3', 'src_name_3'], 'string', 'max' => 255],
            [['product_id_1'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id_1' => 'id']],
            [['product_id_2'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id_2' => 'id']],
            [['product_id_3'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id_3' => 'id']],
            [['related_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['related_cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'bg_color' => Yii::t('app', 'Background Color'),
            'related_cat_id' => Yii::t('app', 'Related Cat ID'),
            'product_id_1' => Yii::t('app', 'Product Id 1'),
            'web_name_1' => Yii::t('app', 'Web Name 1'),
            'src_name_1' => Yii::t('app', 'Src Name 1'),
            'product_id_2' => Yii::t('app', 'Product Id 2'),
            'web_name_2' => Yii::t('app', 'Web Name 2'),
            'src_name_2' => Yii::t('app', 'Src Name 2'),
            'product_id_3' => Yii::t('app', 'Product Id 3'),
            'web_name_3' => Yii::t('app', 'Web Name 3'),
            'src_name_3' => Yii::t('app', 'Src Name 3'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct1()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct2()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct3()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'related_cat_id']);
    }

    /**
     * Возвращает полные URL до файла
     *
     * @return mixed
     */
    public function getUrl1() {
        return Yii::$app->urlManagerMedia->createUrl(Yii::$app->params['hc.uploads.url'] . $this->web_name_1);
    }

    /**
     * Возвращает полный путь до файла
     *
     * @return string
     */
    public function getPath1() {
        return Yii::$app->params['hc.uploads.path'] . $this->web_name_1;
    }

    /**
     * Удаляет файл с диска
     *
     * @return bool
     */
    public function deleteImage1() {
        return @unlink($this->path1);
    }

    /**
     * Возвращает полные URL до файла
     *
     * @return mixed
     */
    public function getUrl2() {
        return Yii::$app->urlManagerMedia->createUrl(Yii::$app->params['hc.uploads.url'] . $this->web_name_2);
    }

    /**
     * Возвращает полный путь до файла
     *
     * @return string
     */
    public function getPath2() {
        return Yii::$app->params['hc.uploads.path'] . $this->web_name_2;
    }

    /**
     * Удаляет файл с диска
     *
     * @return bool
     */
    public function deleteImage2() {
        return @unlink($this->path2);
    }

    /**
     * Возвращает полные URL до файла
     *
     * @return mixed
     */
    public function getUrl3() {
        return Yii::$app->urlManagerMedia->createUrl(Yii::$app->params['hc.uploads.url'] . $this->web_name_3);
    }

    /**
     * Возвращает полный путь до файла
     *
     * @return string
     */
    public function getPath3() {
        return Yii::$app->params['hc.uploads.path'] . $this->web_name_3;
    }

    /**
     * Удаляет файл с диска
     *
     * @return bool
     */
    public function deleteImage3() {
        return @unlink($this->path3);
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $this->deleteImage1();
            $this->deleteImage2();
            $this->deleteImage3();


            return true;
        } else {
            return false;
        }
    }
}
