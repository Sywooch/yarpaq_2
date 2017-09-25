<?php

namespace backend\controllers;

use common\models\Language;
use common\models\slider\SlideImage;
use Yii;
use common\models\slider\Slide;
use common\models\slider\SlideSearch;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;
use yii\web\UploadedFile;


/**
 * SliderController implements the CRUD actions for Slide model.
 */
class SliderController extends Controller
{

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Slide::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }

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
     * Lists all Slide models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SlideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Slide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slide();
        $contents = $this->initContents();

        if ($model->load(Yii::$app->request->post())) {

            $tr = $model->db->beginTransaction();

            try {
                $model->save();

                if (Model::loadMultiple($contents, Yii::$app->request->post()) && Model::validateMultiple($contents)) {

                    foreach ($contents as $content) {
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
            $content = new SlideImage();
            $content->language_id = $language->id;

            $contents[] = $content;
        }

        return $contents;
    }

    /**
     * Updates an existing Slide model.
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

                        $content->image = UploadedFile::getInstance($content, "[$content->id]image");

                        $this->uploadImage($content);

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
     * Deletes an existing Slide model.
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
     * Finds the Slide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slide::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $model SlideImage
     */
    private function uploadImage($model) {
        $image = UploadedFile::getInstance($model, "[$model->id]image");
        if (!is_null($image)) {
            $model->src_name = $image->name;

            // generate a unique file name to prevent duplicate filenames
            $file_parts = explode(".", $image->name);
            $ext = end($file_parts);
            $model->web_name = Yii::$app->security->generateRandomString().".{$ext}";

            $image->saveAs($model->path);
            $model->save();
        }
    }

    private function saveGalleryFiles($m) {
        $files = $m->galleryFiles;
        if (count($files)) {
            $sort = count($m->gallery);
            foreach ($files as $file) { $sort++;
                if (!is_null($file)) {
                    $model = new CategoryImage();
                    $model->model_id = $m->id;
                    $model->src_name = $file->name;
                    $model->sort = $sort;
                    $file_parts = explode(".", $file->name);
                    $ext = end($file_parts);
                    // generate a unique file name to prevent duplicate filenames
                    $model->web_name = Yii::$app->security->generateRandomString().".{$ext}";

                    $file->saveAs($model->path);

                    $model->save();
                }
            }
        }
    }

    public function actionImageDelete() {

        $key = (int) Yii::$app->request->post('key');

        $image = SlideImage::findOne($key);
        if ($image) {

            $image->src_name = '';
            $image->web_name = '';

            $image->save();
        }

        return json_encode(['success' => 1]);
    }
}
