<?php

namespace backend\controllers;

use common\models\Language;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;
use yii\web\UploadedFile;
use common\models\wide_banner\WideBanner;
use common\models\wide_banner\WideBannerImage;
use common\models\wide_banner\WideBannerSearch;


/**
 * WideBannerController implements the CRUD actions for WideBanner model.
 */
class WideBannerController extends AdminDefaultController
{

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => WideBanner::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $b = parent::behaviors();

        $b = ArrayHelper::merge($b, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'        => ['POST'],
                    'image-delete'  => ['POST'],
                ],
            ],
        ]);

        return $b;
    }

    /**
     * Lists all WideBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WideBannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new WideBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WideBanner();
        $contents = $this->initContents();

        if ($model->load(Yii::$app->request->post())) {

            $tr = $model->db->beginTransaction();

            try {
                $model->save();

                $loaded = Model::loadMultiple($contents, Yii::$app->request->post());
                foreach ($contents as $key => $content) {
                    $content->desktopImage = UploadedFile::getInstance($content, "[$key]desktopImage");
                    $content->mobileImage = UploadedFile::getInstance($content, "[$key]mobileImage");
                    $this->uploadImages($content);
                }

                if ($loaded && Model::validateMultiple($contents)) {

                    foreach ($contents as $key => $content) {
                        $content->model_id = $model->id;
                        $content->save(false);
                    }

                    $tr->commit();

                    return $this->redirect('index');
                } else {
                    $tr->rollBack();
                }

            } catch (Exception $e) {
                $tr->rollBack();
            }

            return $this->render('create', [
                'model' => $model,
                'contents' => $contents
            ]);

        } else {

            return $this->render('create', [
                'model' => $model,
                'contents' => $contents
            ]);
        }
    }

    public function initContents() {
        $contents = [];

        $languages = Language::find()->all();
        foreach ($languages as $language) {
            $content = new WideBannerImage();
            $content->language_id = $language->id;

            $contents[] = $content;
        }

        return $contents;
    }

    /**
     * Updates an existing WideBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contents = ArrayHelper::map($model->contents, 'id', function ($model) {
            return $model;
        });

        if ($model->load(Yii::$app->request->post())) {

            $tr = $model->db->beginTransaction();

            try {
                $model->save();

                if (Model::loadMultiple($contents, Yii::$app->request->post()) && Model::validateMultiple($contents)) {

                    foreach ($contents as $content) {
                        $content->model_id = $model->id;
                        $content->desktopImage = UploadedFile::getInstance($content, "[$content->id]desktopImage");
                        $content->mobileImage = UploadedFile::getInstance($content, "[$content->id]mobileImage");
                        $this->uploadImages($content);

                        $content->save(false);
                    }

                    $tr->commit();

                    return $this->redirect('index');
                } else {
                    $tr->rollBack();
                }

            } catch (Exception $e) {
                $tr->rollBack();
            }

            return $this->render('update', [
                'model' => $model,
                'contents' => $contents
            ]);


        } else {

            return $this->render('update', [
                'model' => $model,
                'contents' => $contents
            ]);
        }
    }

    /**
     * Deletes an existing WideBanner model.
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
     * Finds the WideBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WideBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WideBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $model WideBannerImage
     */
    private function uploadImages($model) {
        $image = $model->desktopImage;
        if (!is_null($image)) {
            $model->src_name = $image->name;

            // generate a unique file name to prevent duplicate filenames
            $file_parts = explode(".", $image->name);
            $ext = end($file_parts);

            $model->web_name = Yii::$app->security->generateRandomString().".{$ext}";

            $image->saveAs($model->path);
        }

        $image = $model->mobileImage;
        if (!is_null($image)) {
            $model->src_mb_name = $image->name;

            // generate a unique file name to prevent duplicate filenames
            $file_parts = explode(".", $image->name);
            $ext = end($file_parts);

            $model->web_mb_name = Yii::$app->security->generateRandomString().".{$ext}";

            $image->saveAs($model->mbPath);
        }
    }
}
