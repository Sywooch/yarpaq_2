<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class Seo extends Model
{
    protected $class;
    protected $title = '';
    protected $keywords = '';
    protected $description = '';
    public $image = '';
    public $type = '';
    public $url = '';
    public $canonical;


    public function __construct($title, $class = null, $keywords = null, $description = null) {
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
            return $this->title ? $this->title .' | '.Yii::t('app', 'seo_home_title') : Yii::t('app', 'seo_home_title');
        }
    }

    public function getKeywords() {
        if ($this->class == 'home') {
            return Yii::t('app', 'seo_home_keywords');
        } else {
            return $this->keywords;
        }
    }

    public function getDescription() {
        if ($this->class == 'home') {
            return Yii::t('app', 'seo_home_description');
        } else {
            return $this->description;
        }
    }


}