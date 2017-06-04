<?php

namespace frontend\controllers;



class HomeController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex() {
        return $this->render('index');
    }
}