<?php

namespace backend\controllers;

use webvimark\components\AdminDefaultController;
use Yii;
use common\models\review\Review;
use common\models\review\ReviewSearch;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends AdminDefaultController
{

    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Review model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionActivate($id) {
        $review = Review::findOne($id);

        if ($review && $review->activate()) {
            $this->redirect(Url::to(['review']));
        }

        $this->redirect(Url::to(['review/view', 'id' => $id]));
    }

    public function actionDeactivate($id) {
        $review = Review::findOne($id);

        if ($review && $review->deactivate()) {
            $this->redirect(Url::to(['review']));
        }

        $this->redirect(Url::to(['review/view', 'id' => $id]));
    }
}
