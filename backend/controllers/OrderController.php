<?php

namespace backend\controllers;

use backend\models\OrderProductAddForm;
use common\models\option\ProductOption;
use common\models\OrderOption;
use common\models\Product;
use webvimark\components\AdminDefaultController;
use Yii;
use common\models\order\OrderProduct;
use common\models\order\Order;
use common\models\order\OrderSearch;
use yii\base\Exception;
use yii\base\InvalidValueException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends AdminDefaultController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $b = ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-product-from-order' => ['POST']
                ],
            ],
        ]);
        return $b;
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $order = $this->findModel($id);

        if ($order->load(Yii::$app->request->post())) {

            $isValid = $order->save();

            if (Yii::$app->request->post('OrderProduct')) {
                foreach (Yii::$app->request->post('OrderProduct') as $orderProductData) {
                    $product = Product::findOne($orderProductData['product_id']);

                    if (isset($orderProductData['options'])) {
                        $isValid = $order->addProduct($product, $orderProductData['quantity'], $orderProductData['options']) && $isValid;
                    }

                }

                if ($isValid) {
                    return $this->redirect(['view', 'id' => $order->id]);
                }
            }
        }


        $orderProductAddForm = new OrderProductAddForm();

        return $this->render('update', [
            'model' => $order,
            'orderProductAddForm' => $orderProductAddForm
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteProductFromOrder($order_product_id) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $item = OrderProduct::findOne($order_product_id);

        if ($item && $item->delete()) {
            return ['status' => 1];
        } else {
            return ['status' => 0];
        }
    }
}
