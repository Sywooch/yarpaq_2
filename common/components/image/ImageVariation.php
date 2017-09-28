<?php

namespace common\components\image;


use Imagine\Image\ManipulatorInterface;
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

        if ($thumb->exists()) { // exists
            return $thumb;
        } else {
            $thumb->createFromSource($originalPath);

            if ($thumb->exists()) {
                return $thumb;
            } else {
                Yii::error('Unable to create "'.$thumb->className().'" thumb for '.$originalPath);
                return new EmptyImage();
            }
        }
    }

    public function createFromSource($originalPath) {
        if (is_file($originalPath)) {
            Image::thumbnail($originalPath, $this->width, $this->height, ManipulatorInterface::THUMBNAIL_INSET)
                ->save($this->path, ['jpeg_quality' => 85]);
        } else {
            Yii::error('Source file "'.$originalPath.'" doesn\'t exist');
        }
    }
}