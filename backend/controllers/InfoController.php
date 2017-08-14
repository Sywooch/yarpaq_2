<?php

namespace backend\controllers;

use common\models\info\Info;
use common\models\info\InfoSearch;
use common\models\info\InfoContent;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\models\Language;


/**
 * InfoController implements the CRUD actions for Info model.
 */
class InfoController extends AdminDefaultController
{

    /**
     * Lists all Info models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function generateEmptyContents() {
        // создаем контент для всех языков
        $languages = Language::find()->all();

        $contents = [];

        foreach ($languages as $language) {

            /**
             * @var Language $language
             */
            $content = new InfoContent();
            $content->lang_id = $language->id;

            $contents[] = $content;
        }

        return $contents;
    }

    /**
     * Creates a new Info model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $model = new Info();
        $contents = $this->generateEmptyContents();

        if ($model->load(Yii::$app->request->post()))
        {
            // Начало транзакции
            $transaction = Info::getDb()->beginTransaction();
            $s = true; // content successful save status

            if ($model->save()) {

                foreach ($contents as $content) {

                    $content->attributes = Yii::$app->request->post('InfoContent_'.$content->lang_id);
                    $content->info_id = $model->id;

                    $content_saved = $content->save();
                    if (!$content_saved) $s = false;
                }
            }

            if (!$s) $transaction->rollBack();

            if ($transaction->isActive) {
                $transaction->commit();
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::find()->all(),
            'contents' => $contents
        ]);
    }

    /**
     * Updates an existing Info model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contents = $model->contents;

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Info::getDb()->beginTransaction();
            $s = true;

            $model->save();

            foreach ($contents as $content) {
                /**
                 * @var $content InfoContent
                 */
                $content->attributes = Yii::$app->request->post('InfoContent_'.$content->lang_id);
                if (!$content->save()) { $s = false; }
            }

            if (!$s) $transaction->rollBack();

            if ($transaction->isActive) {
                $transaction->commit();
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'languages' => Language::find()->all(),
            'contents' => $contents
        ]);
    }

    /**
     * Deletes an existing Info model.
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
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Info::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
