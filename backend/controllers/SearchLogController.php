<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\search\SearchLogSearch;
use webvimark\components\AdminDefaultController;

class SearchLogController extends AdminDefaultController
{


    public function actionIndex()
    {
        $searchModel = new SearchLogSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            'user_list_url'     => Url::to(['user/user-list'])
        ]);
    }

}
