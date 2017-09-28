<?php

namespace common\components\image;

use yii\base\Model;

class EmptyImage extends Model implements IImageVariation
{
    public function getUrl() {
        return '';
    }

    public function getPath() {
        return '';
    }
}