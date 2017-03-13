<?php

namespace backend\controllers;

use Yii;
use backend\models\Manufacturer;
use backend\models\ManufacturerSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ManufacturerController implements the CRUD actions for Manufacturer model.
 */
class ManufacturerController extends Controller
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
     * Lists all Manufacturer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManufacturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Manufacturer model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufacturer();

        if ($model->load(Yii::$app->request->post())) {

            $this->uploadImage($model);
            $saved = $model->save();

            if ($saved) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Manufacturer model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $this->uploadImage($model);
            $model->save();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Manufacturer model.
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
     * Finds the Manufacturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manufacturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manufacturer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $model Manufacturer
     */
    private function uploadImage($model) {
        $image = UploadedFile::getInstance($model, 'image');
        if (!is_null($image)) {
            $model->image_src_filename = $image->name;
            $image_parts = explode(".", $image->name);
            $ext = end($image_parts);
            // generate a unique file name to prevent duplicate filenames
            $model->image_web_filename = Yii::$app->security->generateRandomString().".{$ext}";

            $image->saveAs($model->imagePath);

        }
    }

    public function actionImageDelete() {

        $key = (int) Yii::$app->request->post('key');

        $image = ArticleGalleryImage::findOne($key);
        $image->delete();

        return json_encode(['success' => 1]);
    }


    // МЕТОДЫ ДЛЯ СИНХРОНИЗАЦИИ ДАННЫХ СО СТАРОГО САЙТА


    /**
     * Импортирует все бренды, которые еще не импортированы
     *
     * @throws \yii\db\Exception
     */
    public function actionImport() { // TODO удалить данный метод после полного перехода на новый сайт

        // image urls array
        $images = [];

        // load rows
        $rows = Yii::$app->db->createCommand('SELECT * FROM `mans` WHERE manufacturer_id NOT IN ( SELECT old_id FROM man_assoc )')->queryAll();

        // loop
        foreach ($rows as $row) {

            $model = new Manufacturer();
            $model->title = $row['name'];

            // if has image -> download it
            if ($row['image'] != '') {
                $model->image_src_filename = basename($row['image']);
                $model->image_web_filename = basename($row['image']);


                // save image url
                $images[] = $row['image'];
            }

            // save model
            $model->save();

            // add association
            Yii::$app->db->createCommand('REPLACE INTO `man_assoc` VALUES ('.$row['manufacturer_id'].', '.$model->id.')')->execute();

        }

        // print json encoded assoc array
        echo json_encode($images);
    }


    /**
     * Заупускает скачивание всех картинок брендов со старого сайта
     */
    public function actionSyncImages() { // TODO удалить данный метод после полного перехода на новый сайт
        $images = Yii::$app->db->createCommand('SELECT `image` FROM `mans` WHERE image != ""')->queryAll();

        foreach ($images as $image) {
            $this->download($image['image']);
        }
    }

    /**
     * Скачивает картинку.
     * Если картинка с таким именем есть, то ее не скачивает.
     *
     * @param $url
     * @return bool|int|void
     */
    private function download($url) { // TODO удалить данный метод после полного перехода на новый сайт

        // if exist -> skip
        if (is_file('/app/frontend/web/uploads/manufacturers/'.basename($url))) {
            return;
        }

        try {
            $image = file_get_contents('https://yarpaq.az/image/'.$url);
            return file_put_contents('/app/frontend/web/uploads/manufacturers/'.basename($url), $image);
        } catch (ErrorException $e) {
            echo 'Error: '.$url.'<br>';
            return false;
        }
    }
}
