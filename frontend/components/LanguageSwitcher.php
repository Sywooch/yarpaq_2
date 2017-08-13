<?php

namespace frontend\components;


use common\models\Language;
use yii\jui\Widget;

/**
 * Класс, которые отвечает за переключение языков.
 * В каждом view должен быть переменная page, которая является ссылкой на текущую страницу.
 * Из нее берется ссылка на другие языки данной страницы.
 *
 * Если переменной page нет, например страница не найдена, то ссылка языка будет вести на главную страницу
 * на соответствующем языке.
 *
 * Class LanguageSwitcher
 * @package frontend\components
 */
class LanguageSwitcher extends Widget
{
    public $page;

    public function run() {
        $languages = Language::find()->all();

        $html = '';
        foreach ($languages as $language) {
            if ($language == Language::getCurrent()) continue;

            $html .= '<li><a href="'.htmlentities($this->buildLink($language)).'">'.$language->label.'</a></li>';
        }

        return $html;
    }

    private function buildLink($language) {

        if (!$this->page) {
            return $language->urlPrefix.'/';
        } else {
            return $this->page->getUrlByLanguage($language);
        }
    }
}