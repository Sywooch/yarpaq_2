<?php

namespace backend\components;


use common\models\Language;
use yii\jui\Widget;

class LanguageSwitcher extends Widget
{
    public function run() {
        $languages = Language::find()->all();

        $html = '';
        foreach ($languages as $language) {
            $html .= '<a style="display: inline-block" href="'.$language->urlPrefix.'/">'.strtoupper($language->name).'</a>';
        }

        return $html;
    }
}