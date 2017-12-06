<?php

namespace common\models\wide_banner;

use Yii;
use common\models\Language;
use common\models\slider\Slide;

/**
 * This is the model class for table "{{%wide_banner}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $settings
 */
class WideBanner extends Slide
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wide_banner}}';
    }

    public function getContents() {
        return $this->hasMany(WideBannerImage::className(), ['model_id' => 'id']);
    }

    public function getContent() {
        return $this->hasOne(WideBannerImage::className(), ['model_id' => 'id'])->andWhere(['language_id' => Language::getCurrent()->id]);
    }

}
