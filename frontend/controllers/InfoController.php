<?php

namespace frontend\controllers;

use common\models\info\Info;
use frontend\models\ViewedProduct;
use Yii;
use yii\web\NotFoundHttpException;


class InfoController extends BasicController
{

    public $freeAccessActions = ['index'];


    public function actionIndex() {
        $r = Yii::$app->request;
        $url = preg_match('/^[\w_\-\d\/]+$/', $r->get('url')) ? $r->get('url') : '';

        $info = Info::findByUrl($url);
        if (!$info) {
            throw new NotFoundHttpException();
        }

        return $this->render('index', [
            'info'      => $info
        ]);

    }
}