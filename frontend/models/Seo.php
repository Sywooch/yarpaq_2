<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class Seo extends Model
{
    public $title = '';
    public $keywords = '';
    public $description = '';
    public $image = '';
    public $type = '';
    public $url = '';

    public function __construct() {
        $this->url = Yii::$app->request->absoluteUrl;
    }
}