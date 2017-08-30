<?php

namespace common\models\option;

use Yii;
use common\behaviors\Translation;
use yii\db\ActiveRecord;

class OptionValue extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => Translation::className(),
                'tr_model' => OptionValueDescription::className(),
                'rel_field' => 'option_value_id'
            ]
        ];
    }

    public function getName() {
        return $this->content->name;
    }

    public function getUrl() {
        return Yii::$app->urlManagerMedia->createUrl(Yii::$app->params['options.uploads.url'] . $this->image);
    }
}