<?php

namespace common\models\category;

use common\models\Language;
use common\models\Product;
use common\models\Template;
use common\models\User;
use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use common\models\IPage;
use common\models\IDocument;
use yii\base\Event;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $status
 * @property string $created_at
 * @property integer $created_user_id
 * @property string $updated_at
 * @property integer $updated_user_id
 */
class Category extends \yii\db\ActiveRecord implements IPage, IDocument
{
    public $galleryFiles;

    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    const CATEGORY_ACTIVATED    = 'Category activated';
    const CATEGORY_DEACTIVATED  = 'Category deactivated';
    const CATEGORY_DELETED      = 'Category deleted';

    public function init() {

        // авто-деактивация дочерних категорий
        $this->on(self::CATEGORY_DEACTIVATED, function ($event) {
            $category = $event->sender;
            Category::updateAll(['status' => Category::STATUS_HIDDEN], ['and', 'lft>'.$category->lft, 'rgt<'.$category->rgt]);
        });

        $this->on(self::CATEGORY_DEACTIVATED,   ['common\models\Product', 'reIndexAllProducts']);
        $this->on(self::CATEGORY_ACTIVATED,     ['common\models\Product', 'reIndexAllProducts']);
        $this->on(self::CATEGORY_DELETED,       ['common\models\Product', 'reIndexAllProducts']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['settings', 'safe'],
            ['status', 'default', 'value' => self::STATUS_HIDDEN],
            ['template_id', 'default', 'value' => 1],
            ['isTop',  'default', 'value' => 0],
            [['parent_id'], 'required'],
            [['parent_id', 'status', 'template_id'], 'integer'],
            ['galleryFiles', 'required', 'when' => function ($category) {
                $galleryCount = $category->getGallery()->count();
                return $category->isTop == 1 && $galleryCount == 0;
            }]

            // [['created_user_id', 'updated_user_id'], 'required'] // устанавливается автоматически
        ];
    }

    public function getStatusTitle() {
        switch ($this->status) {
            case 1:
                return Yii::t('app', 'Enabled');

                break;
            case 0:
                return Yii::t('app', 'Disabled');

                break;
            default:
                return Yii::t('app', 'UNDEFINED STATUS');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_user_id' => Yii::t('app', 'Created User'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_user_id' => Yii::t('app', 'Updated User'),
            'galleryFiles' => Yii::t('app', 'Icon')
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * Возвращает категорию по ее URL
     *
     * @param $url
     * @return Category|null
     */
    public static function findByUrl($url) {
        if ($url == '') {
            return null;
        }

        $language = Language::getCurrent();

        $home = self::findOne(['parent_id' => 0]);

        $url = trim($url, '/');

        // если пустой url - значит главная страница
        // и главная страница всегда активна, потому что она главная
        // поэтому опубликованость не проверяется
        if ($url == '') {
            return $home;
        }

        // разбиваем url на части
        $names = explode('/', $url);

        $result = $home;

        foreach ($names as $name) {

            // ищем node среди дочерних с конкретным name
            $result = self::find()
                ->select('{{%category}}.*, {{%category_content}}.name')
                ->leftJoin('{{%category_content}}', '{{%category_content}}.`category_id` = {{%category}}.`id`')
                ->where([
                    '{{%category}}.parent_id' => $result->id,
                    '{{%category_content}}.name' => $name,
                    '{{%category_content}}.lang_id' => $language->id
                ])
                ->one();

            // если нет такой страницы
            if (!$result) return null;


            // если страница скрыта
            if (!$result->status) return null;
        }

        return $result;
    }

    /**
     * Возвращает родителя
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->parents(1);
    }


    /**
     * Возвращает дочерние элементы
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildren() {
        return $this->children(1);
    }

    /**
     * Возвращает соседей
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiblings() {
        return static::find()->where(['parent_id' => $this->parent_id]);
    }

    /**
     * Возвращает родителей
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParents($includeRoot = false) {
        if ($includeRoot) {
            return $this->parents();
        } else {
            return $this->parents()->andWhere(['>', 'depth', 1]);
        }
    }

    public static function getRoot() {
        return static::findOne(['parent_id' => 0]);
    }


    /**
     * Возвращает шаблон
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate() {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * Возвращает массив всех контентов
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(CategoryContent::className(), ['category_id' => 'id']);
    }

    /**
     * Возвращает объект контента в соответствии с языком
     *
     * @param Language $language
     * @return null|CategoryContent
     */
    public function getContentByLanguage(Language $language) {
        return $this->hasOne(CategoryContent::className(), ['category_id' => 'id'])->where(['lang_id' => $language->id]);
    }

    /**
     * Возвращает контент страницы по текущему языку
     *
     * @return null|CategoryContent
     */
    public function getContent() {
        return $this->getContentByLanguage(Language::getCurrent());
    }


    public function getUrl($includingSelf = true) {
        return $this->getUrlByLanguage( Language::getCurrent(), $includingSelf );
    }

    public function getTitle() {
        return $this->content->title;
    }

    public function getSeoHeader() {
        return $this->content->seo_header ? $this->content->seo_header : $this->content->title;
    }

    public function getName() {
        return $this->content->name;
    }

    public function isVisible() {
        return $this->status == self::STATUS_ACTIVE;
    }


    /**
     * Возвращает полный путь элемента
     *
     * @param Language $language
     * @param bool|true $includingSelf
     * @return string
     */
    public function getUrlByLanguage(Language $language, $includingSelf = true) {
        $url = $language->getUrlPrefix();

        // если корень, то просты вывести префикс
        if (!$this->parent_id) return $url;

        // все родители
        $parents = $this->getParents()->with('content')->all();

        foreach ($parents as $parent) {

            // пропускаем корень
            if ($parent->parent_id == 0) { continue; }

            // строим URL
            $url .= '/' . $parent->name;
        }


        // если включительно
        if ($includingSelf) {
            $url .= '/'.$this->name;
        }

        $url .= '/';

        return $url;
    }

    public function afterFind() {
        parent::afterFind();

        $this->settings = unserialize($this->settings);
    }

    public function afterDelete() {
        parent::afterDelete();

        $this->trigger(self::CATEGORY_DELETED);
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        // если категория стала не видна
        if (!$this->isVisible() && isset($changedAttributes['status']) && $changedAttributes['status'] == self::STATUS_ACTIVE) {
            $this->trigger(self::CATEGORY_DEACTIVATED);
        }

        // если категория стала видна
        if ($this->isVisible() && isset($changedAttributes['status']) && $changedAttributes['status'] == self::STATUS_HIDDEN) {
            $this->trigger(self::CATEGORY_ACTIVATED);
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            $now = new \DateTime();

            // set Created At
            if ($this->isNewRecord) {
                $this->created_user_id = Yii::$app->user->id;
                $this->created_at = $now->format('Y-m-d H:i:s');
            }

            // set Updated At
            $this->updated_at = $now->format('Y-m-d H:i:s');


            if ($this->parent) {
                $this->depth = $this->parent->depth+1;
            }

            $this->updated_user_id = Yii::$app->user->id;


            // serialize settings
            $this->settings = serialize($this->settings);

            return true;
        }

        return false;
    }

//    public function beforeDelete() {
//        if (parent::beforeDelete()) {
//
//            // delete children
//            $children = $this->children;
//            if (count($children)) {
//                foreach ($children as $child) {
//                    if (!$child->delete()) {
//                        return false;
//                    }
//                }
//            }
//
//
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function getCreatedUser() {
        return $this->hasOne(User::className(), ['id' => 'created_user_id']);
    }

    public function getUpdatedUser() {
        return $this->hasOne(User::className(), ['id' => 'updated_user_id']);
    }

    public static function getData() {
        return ArrayHelper::map(self::find()
            ->where(['>', 'parent_id', 0])
            ->orderBy('lft')
            ->all(),
            'id',
            function ($category) {
                $parents = $category->getParents()->all();

                $title = '';

                foreach ($parents as $parent) {
                    $title .= $parent->title . ' - ';
                }

                $title .= $category->title;

                return $title;
            }
        );
    }

    public function getProducts($categoryIDs = null) {
        $categoryIDs[] = $this->id;

        return $this
            ->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('{{%product_category}}', ['category_id' => 'id'], function ($query) {
                $query->orWhere('in', 'category_id', $this->categoryIDs);
            });
    }

    public function getGallery() {
        return $this->hasMany(CategoryImage::className(), ['model_id' => 'id'])->orderBy('sort');
    }

    public function getIcon() {
        $gallery = $this->gallery;

        if (count($gallery)) {
            return $gallery[0];
        } else {
            return new CategoryImage();
        }
    }

    public function getFullName() {
        $parents = $this->getParents()->all();

        $title = '';

        foreach ($parents as $parent) {
            $title .= $parent->title . ' > ';
        }

        $title .= $this->title;

        return $title;
    }

    public function deactivate() {
        $this->status = self::STATUS_HIDDEN;
        $this->save();
    }

    public function activate() {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }
}
