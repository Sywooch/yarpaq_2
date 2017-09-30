<?php

namespace common\models\product;

use Yii;
use common\components\image\IImageVariation;
use common\components\image\ImageVariation;

class ProductImageStandard extends ImageVariation implements IImageVariation
{

    protected $width = 400;
    protected $height = 400;

    /** @inheritdoc */
    public function getUrl() {
        return Yii::$app->urlManagerProduct->createUrl(Yii::$app->params['product_standard.uploads.url'] . $this->filename);
    }

    /** @inheritdoc */
    public function getPath() {
        return Yii::$app->params['product_standard.uploads.path'] . $this->filename;
    }
}