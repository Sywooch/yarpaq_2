<?php

namespace frontend\models;

use common\models\category\Category;
use common\models\IPage;
use common\models\Product;
use Yii;
use yii\base\Model;

class PageSeo extends Model
{
    protected $page;

    public $keywords = '';
    public $description = '';
    public $image = '';
    public $type = '';
    public $url = '';

    protected $canonical = '';


    public function __construct(IPage $page) {
        parent::__construct();

        $this->page = $page;
        $this->url = Yii::$app->request->absoluteUrl;
    }

    public function getTitle() {
        if ($this->page instanceof Category) {
            return Yii::t('app', 'seo_category_title', [
                'title' => $this->page->title
            ]);
        } else if ($this->page instanceof Product) {
            return Yii::t('app', 'seo_product_title', [
                'title' => $this->page->title
            ]);
        } else {
            return $this->page->title ? $this->page->title .' &mdash; '.Yii::t('app', 'Yarpaq online shop') : Yii::t('app', 'Yarpaq online shop');
        }
    }

    public function getCanonical() {
        if ($this->page instanceof Category) {
            return $this->page->url;
        } else {
            return '';
        }
    }
}