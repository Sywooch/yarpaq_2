<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $label
 * @property string $name
 * @property string $code
 * @property integer $status
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * Переменная, для хранения текущего объекта языка
     *
     * @var null|Language
     */
    static $current = null;

    /**
     * Переменная, для хранения базового объекта языка
     *
     * @var null|Language
     */
    static $default = null;

    /**
     * Возвращает объект текущего языка
     *
     * @return Language
     */
    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefault();
        }
        return self::$current;
    }

    /**
     * Установка текущего объекта языка и локаль пользователя
     *
     * @param null $url
     */
    static function setCurrent($url = null)
    {
        $language = self::getLangByName($url);
        self::$current = ($language === null) ? self::getDefault() : $language;
        Yii::$app->language = self::$current->code;
    }

    /**
     * Получения объекта языка по умолчанию
     *
     * @return null|Language
     */
    static function getDefault()
    {
        if( self::$default === null ){
            self::$default = self::findOne(['id' => 1]);
        }

        return self::$default;
    }

    /**
     * Получения объекта языка по буквенному идентификатору
     *
     * @param null $name
     * @return null|static
     */
    static function getLangByName($name = null)
    {
        if ($name === null) {
            return null;
        } else {
            $language = self::findOne(['name' => $name]);
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }

    public function getUrlPrefix() {
        if ($this->isDefault()) {
            return '/';
        } else {
            return '/'.$this->name.'/';
        }
    }

    public function isDefault() {
        return $this->id === self::getDefault()->id;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'name', 'code', 'status'], 'required'],
            [['status'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 2],
            [['code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
