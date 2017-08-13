<?php

namespace frontend\controllers;


use common\models\IPage;
use webvimark\components\BaseController;

class BasicController extends BaseController
{
    protected function setViewPage(IPage $page) {
        $this->view->params['page'] = $page;
    }
}