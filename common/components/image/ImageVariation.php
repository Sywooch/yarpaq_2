<?php

namespace common\components\image;


use Yii;
use yii\base\Model;
use yii\imagine\Image;

abstract class ImageVariation extends Model implements IImageVariation
{
    protected $filename;
    protected $width;
    protected $height;

    public function __construct($filename) {
        parent::__construct();
        $this->filename     = $filename;
    }

    public function exists() {
        return is_file($this->path);
    }

    public static function get($originalPath, $filename) {
        $thumb = new static($filename);

        if (is_file($thumb->path)) { // exists
            return $thumb;
        } else {
            $thumb->createFromSource($originalPath);

            if ($thumb->exists()) {
                return $thumb;
            } else {
                Yii::error('Unable to create "'.__CLASS__.'" thumb for '.$originalPath);
                return new EmptyImage();
            }
        }
    }

    public function createFromSource($originalPath) {
        Image::thumbnail($originalPath, $this->width, $this->height)
            ->save($this->path, ['jpeg_quality' => 90]);
    }
}