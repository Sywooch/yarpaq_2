<?php

namespace backend\controllers;

use common\models\Country;
use common\models\ProductImage;
use webvimark\components\AdminDefaultController;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AdminDefaultController
{

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id, 'alert' => 'success']);
        } else {
            $zonesData = $this->prepareZonesDataForSelect();

            return $this->render('create', [
                'model' => $model,
                'zones' => $zonesData
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $this->uploadGalleryFiles($model);

            if ($model->save()) {
                $this->saveGalleryFiles($model);
                $this->saveSort();
                return $this->redirect(['update', 'id' => $model->id, 'alert' => 'success']);
            }
        }


        $zonesData = $this->prepareZonesDataForSelect();

        return $this->render('update', [
            'model' => $model,
            'zones' => $zonesData,
        ]);
    }

    private function prepareZonesDataForSelect() {
        $country = Country::findOne(15); // Azerbaijan
        $zones = $country->zones;

        $zonesData = [];
        foreach ($zones as $zone) {
            $zonesData[$zone->id] = $zone->name;
        }

        return $zonesData;
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // Upload

    private function saveSort() {
        $sort = Yii::$app->request->post()['gallery_sort'];

        if ($sort != '') {
            $sort = explode(',', $sort);
            $num = 1;
            foreach ($sort as $s) {
                $model = ProductImage::findOne($s);

                if ($model) {
                    $model->sort = $num++;
                    $model->save();
                }
            }
        }
    }

    private function uploadGalleryFiles($model) {
        $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');
    }

    private function saveGalleryFiles($m) {
        $files = $m->galleryFiles;
        if (count($files)) {
            $sort = count($m->gallery);
            foreach ($files as $file) { $sort++;
                if (!is_null($file)) {
                    $model = new ProductImage();
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

        $image = ProductImage::findOne($key);
        $image->delete();

        return json_encode(['success' => 1]);
    }
}
