<?php

namespace frontend\models;

use common\models\category\Category;
use common\models\IPage;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class PageSeo extends Model
{
    protected $page;

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
            return $this->page->title ? $this->page->title : Yii::t('app', 'Yarpaq online shop');
        }
    }

    public function getCanonical() {
        if ($this->page instanceof Category) {
            return Url::to($this->page->url, true);
        } else {
            return '';
        }
    }

    public function getKeywords() {
        if ($this->page instanceof Category) {
            return Yii::t('app', 'seo_category_keywords', [
                'title' => $this->page->title
            ]);
        } else {
            return '';
        }
    }

    public function getDescription() {
        if ($this->page instanceof Category) {
            return Yii::t('app', 'seo_category_description', [
                'title' => $this->page->title
            ]);
        } else {
            return '';
        }
    }
}