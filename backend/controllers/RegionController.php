<?php

namespace backend\controllers;

use common\models\Zone;
use Yii;
use webvimark\components\AdminDefaultController;
use yii\helpers\ArrayHelper;


/**
 * RegionController implements the CRUD actions for Address model.
 */
class RegionController extends AdminDefaultController
{
    public function actionRegionsByCountry($country_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $models = Zone::find()->where(['country_id' => $country_id])->orderBy('name')->all();
        $data = ArrayHelper::map( $models, 'id', 'name' );

        return ['status' => 1, 'data' => $data];
    }
}
