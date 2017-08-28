<?php

namespace frontend\components;

use Yii;
use common\models\Language;
use yii\jui\Widget;

/**
 * Класс, которые отвечает за переключение языков.
 * В каждом view должен быть переменная page, которая является ссылкой на текущую страницу.
 * Из нее берется ссылка на другие языки данной страницы.
 *
 * Если переменной page нет, например страница не найдена, то меняется префикс.
 *
 * Class LanguageSwitcher
 * @package frontend\components
 */
class LanguageSwitcher extends Widget
{
    public $select = false;
    public $page;

    public function run() {
        $languages = Language::find()->all();

        $html = '';
        foreach ($languages as $language) {
            if ($language == Language::getCurrent()) continue;

            if ($this->select) {
                $html .= '<option value="'.htmlentities($this->buildLink($language)).'">'.$language->label.'</option>';
            } else {
                $html .= '<li><a href="'.htmlentities($this->buildLink($language)).'">'.$language->label.'</a></li>';
            }


        }

        return $html;
    }

    private function buildLink($language) {

        if (!$this->page) {

            return $language->urlPrefix.Yii::$app->request->langUrl;;
        } else {
            return $this->page->getUrlByLanguage($language);
        }
    }
}