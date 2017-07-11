<?php

namespace common\models\option;

use common\behaviors\Translation;
use common\models\Language;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%option}}".
 *
 * @property integer $id
 * @property string $type
 */
class Option extends ActiveRecord
{

    public function behaviors()
    {
        return [
            'translation' => [
                'class' => Translation::className(),
                'tr_model' => OptionDescription::className(),
                'rel_field' => 'option_id'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    public function getValues() {
        return $this->hasMany(OptionValue::className(), ['option_id' => 'id']);
    }

    public function getName() {
        return $this
            ->hasOne(OptionDescription::className(), ['option_id' => 'id'])
            ->andWhere(['language_id' => Language::getCurrent()->id])
            ->one()->name;
    }
}
