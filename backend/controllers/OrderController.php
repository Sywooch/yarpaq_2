<?php

namespace backend\controllers;

use backend\models\OrderProductAddForm;
use common\models\Country;
use common\models\Currency;
use common\models\Language;
use common\models\option\ProductOption;
use common\models\OrderOption;
use common\models\payment\PaymentMethod;
use common\models\Product;
use common\models\shipping\ShippingMethod;
use common\models\Zone;
use Faker\Provider\tr_TR\DateTime;
use webvimark\components\AdminDefaultController;
use Yii;
use common\models\order\OrderProduct;
use common\models\order\Order;
use common\models\order\OrderSearch;
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
