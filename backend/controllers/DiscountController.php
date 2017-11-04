<?php


namespace backend\controllers;


use Yii;
use common\models\Product;
use common\models\product\Discount;
use common\models\User;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

class DiscountController extends AdminDefaultController
{
    public $enableOnlyActions = ['index', 'delete'];

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors = ArrayHelper::merge($behaviors, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'        => ['POST'],
                ],
            ],
        ]);

        return $behaviors;
    }

    public function actionIndex($id)
    {
        $product = Product::findOne($id);
        $this->denyIfNotOwner($product);

        $discount = $product->discount ? $product->discount : new Discount();

        if ($discount->load(Yii::$app->request->post())) {
            $product->setDiscount($discount);
            $this->redirect(['index', 'id' => $product->id]);
        }


        // render
        return $this->render('index', [
            'product'   => $product,
            'discount'  => $discount
        ]);
    }

    public function actionDelete($product_id) {
        $discount = Discount::find(['product_id' => $product_id])->one();
        if ($discount) {
            $discount->delete();
        }

        $this->redirect(['discount/index', 'id' => $product_id]);
    }

    /**
     * проверка на авторство
     *
     * @param $model
     * @return bool
     * @throws ForbiddenHttpException
     */
    protected function denyIfNotOwner($model) {
        if ($model->user_id != User::getCurrentUser()->id && !User::hasPermission('manage_discount_to_any_product')) {
            throw new ForbiddenHttpException('You don\'t have permissions to access this product');
        }
        return true;
    }
}