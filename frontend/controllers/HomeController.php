<?php

namespace frontend\controllers;



class HomeController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex() {
        $this->seo('', null, null, null, 'home');

        return $this->render('index');
    }
}