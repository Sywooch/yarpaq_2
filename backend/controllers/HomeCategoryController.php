<?php

namespace backend\controllers;

use Yii;
use common\models\appearance\HomeCategory;
use common\models\appearance\HomeCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * HomeCategoryController implements the CRUD actions for HomeCategory model.
 */
class HomeCategoryController extends Controller
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

    /**
     * Lists all HomeCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HomeCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new HomeCategory model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HomeCategory();

        if ($model->load(Yii::$app->request->post())) {

            $this->handleImage($model, 1);
            $this->handleImage($model, 2);
            $this->handleImage($model, 3);

            if ($model->save()) {
                $this->showSuccessMessage();
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing HomeCategory model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $this->handleImage($model, 1);
            $this->handleImage($model, 2);
            $this->handleImage($model, 3);

            if ($model->save()) {
                $this->showSuccessMessage();
                return $this->redirect(['update', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HomeCategory model.
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
     * Finds the HomeCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HomeCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HomeCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    private function handleImage($category, $num) {
        $image = UploadedFile::getInstance($category, "image".$num);

        if (!is_null($image)) {
            $category->{'image'.$num} = $image;
            $category->{'src_name_'.$num} = $image->name;

            // generate a unique file name to prevent duplicate filenames
            $file_parts = explode(".", $image->name);
            $ext = end($file_parts);
            $category->{'web_name_'.$num} = Yii::$app->security->generateRandomString().".{$ext}";

            $image->saveAs($category->{'path'.$num});
        }
    }

    protected function showSuccessMessage() {
        Yii::$app->session->setFlash('success', Yii::t('app', 'Saved'));
    }
}
