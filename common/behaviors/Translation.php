<?php

namespace common\behaviors;

use backend\models\Language;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;


/**
 * Class Translation
 *
 * Помогает управлять переводами модели.
 * Обеспечивает наличие полного набора переводов и обращение к ним
 *
 * @package common\behaviors
 */
class Translation extends Behavior
{

    /**
     * @var array Массив переводов на все языки
     */
    protected $container = [];

    /**
     * @var ActiveRecord Модель текущего перевода
     */
    public $content;

    /**
     * @var string Название класса-перевода
     */
    public $tr_model;

    /**
     * @var string Название связующего поля
     */
    public $rel_field;


    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'fillContainerWithEmptyModelsOfAllLanguages',
            ActiveRecord::EVENT_AFTER_FIND => 'loadTranslations'
        ];
    }

    /**
     * Создание болванок-моделей переводов по всем языкам
     */
    public function fillContainerWithEmptyModelsOfAllLanguages() {
        $languages = Language::find()->all();

        foreach ($languages as $language) {
            $model = new $this->tr_model();
            $model->language_id = $language->id;
            $this->container[ $language->id ] = $model;
        }
    }

    /**
     * Подгрузка имеющихся переводов из базы
     * Установка текущего перевода
     */
    public function loadTranslations() {
        $this->fillEmptyModels();
        $this->setCurrentTranslation();
    }


    /**
     * Заполнение болванок данными из базы
     */
    protected function fillEmptyModels() {
        $models = $this->owner->hasMany($this->tr_model, [$this->rel_field => 'id'])->all();

        foreach ($models as $model) {
            $this->container[ $model->language_id ] = $model;
        }
    }

    /**
     * Установка текузего перевода
     */
    private function setCurrentTranslation() {
        $this->content = $this->getTranslationByLanguageID(Language::getCurrent()->id);
    }

    /**
     * Получение перевода по конкретному языку
     *
     * @param $language_id Integer ID языка
     * @return mixed
     */
    public function getTranslationByLanguageID($language_id) {
        if (isset($this->container[ $language_id ])) {
            return $this->container[ $language_id ];
        }

        return null;
    }

    /**
     * Получение массива переводов
     *
     * @return array
     */
    public function getContents() {
        return $this->container;
    }
}