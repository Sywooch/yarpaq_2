<?php

namespace common\models\category;

use Yii;
use backend\models\Language;

/**
 * This is the model class for table "{{%category_content}}".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $category_id
 * @property string $title
 * @property string $name
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Language $lang
 * @property Category $category
 */
class CategoryContent extends \yii\db\ActiveRecord
{
    protected $uploadDir = 'category';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            /**
             * обязательные поля
             */
            [['lang_id', 'category_id', 'title', 'name'], 'required'],


            /**
             * числа
             */
            [['lang_id', 'category_id'], 'integer'],

            /**
             * строки
             */
            [['seo_keywords', 'seo_description'], 'string'],

            /**
             * строки с ограничением
             */
            [['title', 'name'], 'string', 'max' => 255],


            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Name (url)'),
            'seo_keywords' => Yii::t('app', 'SEO Keywords'),
            'seo_description' => Yii::t('app', 'SEO Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Перед сохранением прописать дату обновления и дату создания
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if (!$this->isUnique()) return false; // check unique

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

    /**
     * Проверка на уникальность категории
     *
     * @return bool
     */
    protected function isUnique() {

        // find all contents which have same name and language
        $sameNameNodes = self::findAll([
            'name' => $this->name,
            'lang_id' => $this->lang_id,
        ]);


        foreach ($sameNameNodes as $node) {
            if ($this->category->parent_id == $node->category->parent_id) {
                if ($this->isNewRecord || $this->id != $node->id) {
                    $this->addError('name', 'This name is already in use');
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
