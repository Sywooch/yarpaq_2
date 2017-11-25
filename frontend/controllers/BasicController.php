<?php

namespace frontend\controllers;


use common\models\IPage;
use frontend\models\PageSeo;
use Yii;
use frontend\models\Seo;
use webvimark\components\BaseController;

class BasicController extends BaseController
{
    protected function seo($title = '', $image = null, $description = null, $keywords = null, $type = '') {
        $seo = new Seo($title, $type);

        if ($image) {
            $seo->image = $image;
        }

        $seo->description = strip_tags($description);
        $seo->keywords = strip_tags($keywords);

        $this->view->params['seo'] = $seo;
    }

    protected function pageSeo(IPage $page) {
        $this->view->params['seo'] = new PageSeo($page);
    }


    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        $this->seo();

        return true; // or false to not run the action
    }
}