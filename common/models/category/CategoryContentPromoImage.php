<?php

namespace common\models\category;

use Yii;

/**
 * @inheritdoc
 */
class CategoryContentPromoImage extends CategoryImage
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_content_promo_image}}';
    }
}
