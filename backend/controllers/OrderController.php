<?php

namespace backend\controllers;

use backend\models\OrderProductAddForm;
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $isValid = $model->validate();

            $orderProducts = [];
            foreach (Yii::$app->request->post('OrderProduct') as $orderProductData) {
                $orderProduct = new OrderProduct();
                $orderProduct->attributes = $orderProductData;

                $isValid = $orderProduct->validate() && $isValid;

                $orderProducts[] = $orderProduct;
            }

            if ($isValid) {
                $model->save(false);

                foreach ($orderProducts as $orderProduct) {
                    $orderProduct->save(false);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        $orderProductAddForm = new OrderProductAddForm();
        return $this->render('update', [
            'model' => $model,
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

    /**
     * Добавляет товар к заказу.
     * Возвращает ID связи товара с заказом
     *
     * @return array
     */
    public function actionAddProductToOrder() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $order_id = Yii::$app->request->post('order_id');
        $product_id = Yii::$app->request->post('product_id');

        $order      = Order::findOne($order_id);
        $product    = Product::findOne($product_id);

        if (!$order) { throw new InvalidValueException('Order '.$order_id.' not found'); }
        if (!$product) { throw new InvalidValueException('Product '.$product_id.' not found'); }

        // сначала создаем товар к заказу

        $order->addProduct($product, Yii::$app->request->post('options'));



        if ($product) {
            return ['status' => 1, 'data' => $product->toArray(['id', 'title', 'model', 'price'])];
        } else {
            return ['status' => 0, 'error' => 'Product not found'];
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
