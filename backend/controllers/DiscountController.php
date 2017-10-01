<?php


namespace backend\controllers;


use Yii;
use common\models\Product;
use common\models\product\Discount;
use common\models\User;
use webvimark\components\AdminDefaultController;
use yii\web\ForbiddenHttpException;

class DiscountController extends AdminDefaultController
{
    public $enableOnlyActions = ['index'];


    public function actionIndex($id)
    {
        $product = Product::findOne($id);
        $this->denyIfNotOwner($product);

        $discount = $product->discount ? $product->discount : new Discount(['product_id' => $product->id]);

        if ($discount->load(Yii::$app->request->post()) && $discount->save()) {

            // TODO update elasticsearch index

            $this->redirect(['index', 'id' => $product->id]);
        }


        // render
        return $this->render('index', [
            'product'   => $product,
            'discount'  => $discount
        ]);
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