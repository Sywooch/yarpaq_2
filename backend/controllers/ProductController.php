<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Country;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\ProductImage;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use webvimark\components\AdminDefaultController;
use common\components\ProductSearch as ElasticProductSearch;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AdminDefaultController
{

    public $enableOnlyActions = ['index', 'create', 'update', 'delete', 'list', 'info'];

    public function behaviors() {
        $b = parent::behaviors();

        $b = ArrayHelper::merge($b, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'        => ['POST'],
                    'image-delete'  => ['POST'],
                    'bulk'          => ['POST']
                ],
            ],
        ]);

        return $b;
    }

    /**
     * Lists all Product models.
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        Yii::$app->session->set('product_redirect', Yii::$app->request->absoluteUrl);

        $searchModel            = new ProductSearch();

        $searchModel->load(Yii::$app->request->queryParams);
        if (!User::hasPermission('view_all_products')) {
            $searchModel->user_id = User::getCurrentUser()->id;
        }

        $dataProvider = $searchModel->search();

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

        if (User::hasRole('seller', false)) {
            $model->user_id   = User::getCurrentUser()->id;
            $model->scenario  = Product::SCENARIO_SELLER;
        }


        if ($model->load(Yii::$app->request->post())) {
            $this->uploadGalleryFiles($model);

            if ($model->save()) {
                $this->indexProduct($model); // send data to Elastic search

                $this->saveGalleryFiles($model);
                $this->saveSort();
                return $this->redirect(['update', 'id' => $model->id, 'alert' => 'success']);
            }
        }

        $zonesData = $this->prepareZonesDataForSelect();

        return $this->render('create', [
            'model' => $model,
            'zones' => $zonesData
        ]);
    }

    public function indexProduct($product) {
        $search = new ElasticProductSearch();
        $search->index($product);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'update' page.
     *
     * @param int $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->denyIfNotOwner($model);

        if (!User::hasRole('admin', false)) {
            $model->scenario  = Product::SCENARIO_SELLER;
        }

        $moderated = $model->moderated;

        if ($model->load(Yii::$app->request->post())) {
            $this->uploadGalleryFiles($model);


            // если меняется статус модерации
            // и у юзера есть полномочия
            if ($model->moderated != $moderated && User::hasPermission('moderate_products')) {
                $model->moderated_at = (new \DateTime())->format('Y-m-d H:i:s');
            }
            // иначе возвращаем в исходное состояние
            else {
                $model->moderated = $moderated;
            }


            // если товар сохранил не админ,
            // то отправить товар на модерацию
            if (!User::hasRole('admin')) {
                $model->moderated = 0;
            }


            if ($model->save()) {
                $this->indexProduct($model); // send data to Elastic search

                $this->saveGalleryFiles($model);
                $this->saveSort();

                if (Yii::$app->session->has('product_redirect')) {
                    $product_redirect = Yii::$app->session->get('product_redirect');
                    Yii::$app->session->remove('product_redirect');

                    return $this->redirect($product_redirect);
                } else {
                    return $this->redirect(['index']);
                }
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
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $this->denyIfNotOwner($model);

        $model->delete();

        $this->redirect( Yii::$app->request->referrer );
    }

    public function actionBulk() {
        $action = Yii::$app->request->post('action');
        $selection = Yii::$app->request->post('selection');

        $products = Product::find()
            ->andWhere(['in', 'id', $selection])
            ->all();

        foreach ($products as $product) {
            if ($action == 'delete') {

                $this->denyIfNotOwner($product);
                $product->delete();
            }
        }

        $this->redirect( Yii::$app->request->referrer );
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

    /**
     * проверка на авторство
     *
     * @param $model
     * @return bool
     * @throws ForbiddenHttpException
     */
    protected function denyIfNotOwner($model) {
        if ($model->user_id != User::getCurrentUser()->id && !User::hasPermission('crud_any_product')) {
            throw new ForbiddenHttpException('You don\'t have permissions to access this product');
        }
        return true;
    }

    public function actionImageDelete() {

        $key = (int) Yii::$app->request->post('key');

        $image = ProductImage::findOne($key);
        if ($image) {
            $product = $image->product;

            $this->denyIfNotOwner($product);
            $image->delete();
        }

        return json_encode(['success' => 1]);
    }

    /**
     * Ищет по названию и выдает список товаров (Ajax)
     *
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $models = ProductSearch::find()
                ->andWhere(['or',
                    ['like', 'title', $q],
                    ['id' => $q]
                ])->all();

            $out['results'] = [];
            foreach ($models as $model) {
                $out['results'][] = ['id' => $model->id, 'text' => $model->title . ' ('.$model->id.')'];
            }
        }
        elseif ($id > 0) {
            $model = Product::find($id);
            $out['results'] = ['id' => $id, 'text' => $model->title . ' ('.$model->id.')'];
        }
        return $out;
    }

    /**
     * Выдает информацию о конкретном товаре (Ajax)
     *
     * @param $product_id
     * @return array
     */
    public function actionInfo($product_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $product = Product::findOne($product_id);

        if (Yii::$app->request->get('options')) {
            $options = Yii::$app->request->get('options');

            foreach ($options as $option => $value) {
                $product_option         = ProductOption::findOne($option);
                $product_option_value   = ProductOptionValue::findOne($value);
                $product->applyOption($product_option, $product_option_value);
            }
        }

        return [
            'status'    => 1,
            'data'      => [
                'id' => $product_id,
                'title' => $product->getTitleWithOptions(),
                'model' => $product->model,
                'price' => $product->getRealPrice(true),
                'currency' => $product->currency->code
            ]
        ];
    }

    public function actionChangeStatusAjax() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!User::hasPermission('change_product_status')) {
            throw new ForbiddenHttpException();
        }

        $product_id = Yii::$app->request->post('product_id');
        $status_id = Yii::$app->request->post('status_id');

        $product = Product::findOne($product_id);
        if (!$product) {
            throw new NotFoundHttpException();
        }


        $product->status_id = $status_id;
        if ( $product->save() ) {
            return ['status' => 1];
        } else {
            return ['status' => 0];
        }

    }
}
