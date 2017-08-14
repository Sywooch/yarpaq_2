<?php

namespace common\models\info;

use Yii;
use common\models\Language;

/**
 * This is the model class for table "{{%info_content}}".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property integer $info_id
 * @property string $title
 * @property string $name
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Info $info
 * @property Language $lang
 */
class InfoContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%info_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'info_id', 'title', 'name'], 'required'],
            [['lang_id', 'info_id'], 'integer'],
            [['seo_keywords', 'seo_description'], 'string'],
            [['title', 'name'], 'string', 'max' => 255],
            [['info_id'], 'exist', 'skipOnError' => true, 'targetClass' => Info::className(), 'targetAttribute' => ['info_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
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
            'info_id' => Yii::t('app', 'Info ID'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Name'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_description' => Yii::t('app', 'Seo Description'),
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

            if ($this->isNewRecord || $this->id != $node->id) {
                $this->addError('name', 'This name is already in use');
                return false;
            }

        }

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfo()
    {
        return $this->hasOne(Info::className(), ['id' => 'info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
}
