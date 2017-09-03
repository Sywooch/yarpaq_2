<?php

namespace frontend\controllers;


use Yii;
use frontend\models\Seo;
use webvimark\components\BaseController;

class BasicController extends BaseController
{
    protected function seo($title = '', $image = null) {

        $seo = new Seo();
        $seo->title = $title ? $title .' &mdash; '.Yii::t('app', 'Yarpaq online mağaza') : Yii::t('app', 'Yarpaq online mağaza');

        if ($image) {
            $seo->image = $image;
        }

        $this->view->params['seo'] = $seo;
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