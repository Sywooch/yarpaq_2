<?php

namespace common\models\product;

use Yii;
use common\components\image\IImageVariation;
use common\components\image\ImageVariation;

class ProductImagePreview extends ImageVariation implements IImageVariation
{

    protected $width = 200;
    protected $height = 200;

    /** @inheritdoc */
    public function getUrl() {
        return Yii::$app->urlManagerProduct->createUrl(Yii::$app->params['product_preview.uploads.url'] . $this->filename);
    }

    /** @inheritdoc */
    public function getPath() {
        return Yii::$app->params['product_preview.uploads.path'] . $this->filename;
    }
}