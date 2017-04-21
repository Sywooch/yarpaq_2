<?php

namespace common\models\category;

use backend\models\Language;
use common\models\Template;
use common\models\User;
use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use common\models\IPage;
use common\models\IDocument;

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

    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

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
            [['parent_id', 'status', 'template_id'], 'required'],
            [['parent_id', 'status', 'template_id'], 'integer'],

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
    public function getParents() {
        return $this->parents();
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

    public function getName() {
        return $this->content->name;
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

        // убираем home url, он не учитывается
        foreach ($parents as $parent) {

            // пропускаем корень
            if ($parent->parent_id == 0) { continue; }

            // строим URL
            $url .= $parent->name.'/';
        }


        // если включительно
        if ($includingSelf) {
            $url .= $this->name . '/';
        }

        return $url;
    }

    public function afterFind() {
        parent::afterFind();

        $this->settings = unserialize($this->settings);
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

    public function beforeDelete() {
        if (parent::beforeDelete()) {

            // delete children
            $children = $this->children;
            if (count($children)) {
                foreach ($children as $child) {
                    if (!$child->delete()) {
                        return false;
                    }
                }
            }


            return true;
        } else {
            return false;
        }
    }

    public function getCreatedUser() {
        return $this->hasOne(User::className(), ['id' => 'created_user_id']);
    }

    public function getUpdatedUser() {
        return $this->hasOne(User::className(), ['id' => 'updated_user_id']);
    }
}