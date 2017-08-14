<?php

namespace common\models\info;

use common\models\Language;
use common\models\User;
use Yii;
use common\models\IDocument;
use common\models\IPage;
use common\models\Template;

/**
 * This is the model class for table "{{%info}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $template_id
 * @property string $created_at
 * @property integer $created_user_id
 * @property string $updated_at
 * @property integer $updated_user_id
 * @property string $settings
 *
 * @property Template $template
 */
class Info extends \yii\db\ActiveRecord implements Ipage, IDocument
{
    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'template_id'], 'required'],
            [['status', 'template_id', 'created_user_id', 'updated_user_id'], 'integer'],
            [['settings'], 'string', 'max' => 255],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
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
            'status' => Yii::t('app', 'Status'),
            'template_id' => Yii::t('app', 'Template ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_user_id' => Yii::t('app', 'Created User ID'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_user_id' => Yii::t('app', 'Updated User ID'),
            'settings' => Yii::t('app', 'Settings'),
        ];
    }

    /**
     * Возвращает инфо-страницу по ее URL
     *
     * @param $url
     * @return Info|null
     */
    public static function findByUrl($url) {
        $language = Language::getCurrent();

        $url = trim($url, '/');

        $info = Info::find()
            ->select('{{%info}}.*, {{%info_content}}.name')
            ->leftJoin('{{%info_content}}', '{{%info_content}}.`info_id` = {{%info}}.`id`')
            ->where([
                '{{%info_content}}.name' => $url,
                '{{%info_content}}.lang_id' => $language->id
            ])
            ->one();

        // если нет такой страницы
        if (!$info) return null;


        // если страница скрыта
        if ($info->status != Info::STATUS_ACTIVE) return null;

        return $info;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
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
            $this->updated_user_id = Yii::$app->user->id;


            // serialize settings
            $this->settings = serialize($this->settings);

            return true;
        }

        return false;
    }

    public function afterFind() {
        parent::afterFind();

        $this->settings = unserialize($this->settings);
    }

    public function getCreatedUser() {
        return $this->hasOne(User::className(), ['id' => 'created_user_id']);
    }

    public function getUpdatedUser() {
        return $this->hasOne(User::className(), ['id' => 'updated_user_id']);
    }

    /**
     * Возвращает массив всех контентов
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(InfoContent::className(), ['info_id' => 'id']);
    }

    /**
     * Возвращает контент страницы по текущему языку
     *
     * @return null|InfoContent
     */
    public function getContent() {
        return $this->getContentByLanguage(Language::getCurrent());
    }

    /**
     * Возвращает объект контента в соответствии с языком
     *
     * @param Language $language
     * @return null|InfoContent
     */
    public function getContentByLanguage(Language $language) {
        return $this->hasOne(InfoContent::className(), ['info_id' => 'id'])->where(['lang_id' => $language->id]);
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

        $url .= 'info';

        // если включительно
        if ($includingSelf) {
            $url .= '/'.$this->name;
        }

        $url .= '/';

        return $url;
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
}
