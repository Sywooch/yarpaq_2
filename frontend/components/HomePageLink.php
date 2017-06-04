<?php

namespace frontend\components;

use common\models\Language;
use Yii;
use yii\base\Widget;

class HomePageLink extends Widget
{
    public function run() {
        if (Yii::$app->language == Language::getDefault()->name) {
            return '/';
        }

        return '/'.Yii::$app->language;
    }
}