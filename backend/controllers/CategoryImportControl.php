<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class CategoryImportController extends Controller
{
    public function actionIndex() {
        ini_set('memory_limit', '-1');

        $this->importCategories();
    }

    private function importCategories() {

    }
}