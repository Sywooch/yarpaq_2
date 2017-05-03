<?php

namespace backend\controllers;

use webvimark\components\AdminDefaultController;
use Yii;
use common\models\option\Option;
use common\models\option\OptionSearch;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class OptionController extends AdminDefaultController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionTest() {
        $option_id = 22;

        $option = Option::findOne($option_id);

        echo $option->content->name;
//        $translation = $option->translation;

        return null;
    }

    /**
     * Lists all Option models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Option model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $option = new Option();

        if (
            $option->load(Yii::$app->request->post())
            &&
            Model::loadMultiple($option->contents, Yii::$app->request->post())
        ) {

            $option->save();
            foreach ($option->contents as $content) {
                $content->link('option', $option);
                $content->save();
            }

            return $this->redirect(['update', 'id' => $option->id]);
        } else {
            return $this->render('create', [
                'model' => $option,
            ]);
        }
    }

    /**
     * Updates an existing Option model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $option = $this->findModel($id);

        if (
            $option->load(Yii::$app->request->post())
            &&
            Model::loadMultiple($option->contents, Yii::$app->request->post())
        ) {

            $option->save();
            foreach ($option->contents as $content) {
                $content->link('option', $option);
                $content->save();
            }

            return $this->redirect(['update', 'id' => $option->id]);
        } else {
            return $this->render('update', [
                'model' => $option,
            ]);
        }
    }

    /**
     * Deletes an existing Option model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Option model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Option the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Option::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
