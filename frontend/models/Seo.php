<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class Seo extends Model
{
    protected $class;
    protected $title = '';
    public $keywords = '';
    public $description = '';
    public $image = '';
    public $type = '';
    public $url = '';


    public function __construct($title, $class = null) {
        parent::__construct();

        $this->title = $title;
        $this->class = $class;
        $this->url = Yii::$app->request->absoluteUrl;
    }

    public function getTitle() {
        if ($this->class == 'category') {
            return Yii::t('app', 'seo_category_title', [
                'title' => $this->title
            ]);
        } else if ($this->class == 'product') {
            return Yii::t('app', 'seo_product_title', [
                'title' => $this->title
            ]);
        } else {
            return $this->title ? $this->title .' &mdash; '.Yii::t('app', 'Yarpaq online shop') : Yii::t('app', 'Yarpaq online shop');
        }
    }
}