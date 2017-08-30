<?php

namespace backend\controllers;

use common\models\order\OrderStatus;
use common\models\User;
use Yii;
use backend\models\OrderProductAddForm;
use common\models\Country;
use common\models\Currency;
use common\models\Language;
use common\models\payment\PaymentMethod;
use common\models\Product;
use common\models\shipping\ShippingMethod;
use common\models\Zone;
use webvimark\components\AdminDefaultController;
use common\models\order\OrderProduct;
use common\models\order\Order;
use common\models\order\OrderSearch;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
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
                    'confirm-delete' => ['POST'],
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


        $searchModel->load(Yii::$app->request->queryParams);
        if (!User::hasPermission('view_all_orders')) {
            $searchModel->user_id   = User::getCurrentUser()->id;
        }
        $dataProvider = $searchModel->search();


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
        $order = new Order();

        if ($order->load(Yii::$app->request->post())) {

            $currency               = Currency::findOne(1); // TODO прописывать чтото дельное
            $order->currency_id     = $currency->id;
            $order->currency_code   = $currency->code;

            $order->payment_country = Country::findOne($order->payment_country_id)->name;
            $order->shipping_country = Country::findOne($order->shipping_country_id)->name;

            $payment_method = PaymentMethod::findOne($order->payment_method_id);
            $order->payment_code    = $payment_method->code;
            $order->payment_method  = $payment_method->name;

            $payment_zone = Zone::findOne($order->payment_zone_id);
            $order->payment_zone    = $payment_zone->name;

            $shipping_method = ShippingMethod::findOne($order->shipping_method_id);
            $order->shipping_code    = $shipping_method->code;
            $order->shipping_method  = $shipping_method->name;

            $shipping_zone = Zone::findOne($order->shipping_zone_id);
            $order->shipping_zone   = $shipping_zone->name;



            $order->language_id     = Language::getCurrent()->id;
            $order->user_agent      = Yii::$app->request->userAgent;
            $order->ip              = Yii::$app->request->userIP;
            $order->accept_language = implode(';', Yii::$app->request->acceptableLanguages);
            $order->created_at      = (new \DateTime())->format('Y-m-d H:i:s');
            $order->modified_at     = $order->created_at;



            if ($order->save()) {
                return $this->redirect(['view', 'id' => $order->id]);
            }

        }

        $orderProductAddForm = new OrderProductAddForm();
        return $this->render('create', [
            'model' => $order,
            'orderProductAddForm' => $orderProductAddForm
        ]);
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
            }

            if ($isValid) {
                return $this->redirect(['update', 'id' => $order->id]);
            }
        }


        $orderProductAddForm = new OrderProductAddForm();

        return $this->render('update', [
            'model' => $order,
            'orderProductAddForm' => $orderProductAddForm
        ]);
    }

    public function actionDelete($id) {

        $order = $this->findModel($id);

        return $this->render('delete', [
            'order' => $order
        ]);
    }

    public function actionChangeStatusAjax() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!User::hasPermission('change_order_status')) {
            throw new ForbiddenHttpException();
        }

        $order_id = Yii::$app->request->post('order_id');
        $status_id = Yii::$app->request->post('status_id');

        $order = Order::findOne($order_id);
        if (!$order) {
            throw new NotFoundHttpException();
        }

        $status = OrderStatus::findOne($status_id);
        if (!$status) {
            throw new NotFoundHttpException();
        }

        $order->order_status_id = $status->order_status_id;
        if ( $order->save() ) {
            return ['status' => 1];
        } else {
            return ['status' => 0];
        }

    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionConfirmDelete($id)
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
