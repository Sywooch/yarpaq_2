<?php

namespace backend\controllers;

use common\models\option\Option;
use common\models\option\OptionValue;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\Product;
use common\models\User;
use Yii;
use webvimark\components\AdminDefaultController;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * ProductOptionController implements the CRUD actions for Product model.
 */
class ProductOptionController extends AdminDefaultController
{
    public $enableOnlyActions = ['index', 'add-option', 'update', 'delete', 'check-for-options'];

    public function behaviors() {
        $b = parent::behaviors();

        $b = ArrayHelper::merge($b, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);

        return $b;
    }

    /**
     * проверка на авторство
     *
     * @param $model
     * @return bool
     * @throws ForbiddenHttpException
     */
    protected function denyIfNotOwner($model) {
        if ($model->user_id != User::getCurrentUser()->id && !User::hasPermission('crud_option_to_any_product')) {
            throw new ForbiddenHttpException('You don\'t have permissions to access this product');
        }
        return true;
    }

    public function actionIndex($id)
    {
        $product = Product::findOne($id);
        $this->denyIfNotOwner($product);


        return $this->render('index', [
            'model' => $product
        ]);
    }

    public function actionUpdate($id) {
        $product = Product::findOne($id);
        $this->denyIfNotOwner($product);

        if (Yii::$app->request->post('option_value_id')) {
            $option_value_id    = Yii::$app->request->post('option_value_id');
            $quantity           = Yii::$app->request->post('quantity');
            $price_prefix       = Yii::$app->request->post('price_prefix');
            $price              = Yii::$app->request->post('price');


            for ($i=1; $i<count($option_value_id); $i++) {
                $value                      = new ProductOptionValue();
                $value->product_option_id   = Yii::$app->request->post('product_option_id');
                $value->option_value_id     = $option_value_id[$i];
                $value->quantity            = $quantity[$i];
                $value->price_prefix        = $price_prefix[$i];
                $value->price               = $price[$i];

                $value->save();
            }
        }


        $this->deleteOptionValues();

        $productOptionId = (int) Yii::$app->request->post('product_option_id');

        $productOptionValues = ProductOptionValue::find()->where(['product_option_id' => $productOptionId])->all();
        $productOptionValues = ArrayHelper::index($productOptionValues, 'id');

        foreach ($productOptionValues as $productOptionValue) {
            $productOptionValue->scenario = ProductOptionValue::SCENARIO_UPDATE;
        }

        if (Model::loadMultiple($productOptionValues, Yii::$app->request->post()) && Model::validateMultiple($productOptionValues)) {
            foreach ($productOptionValues as $productOptionValue) {
                $productOptionValue->save(false);
            }
            return $this->redirect(['index', 'id' => $product->id]);
        }

        return $this->render('index', ['model' => $product]);

    }


    public function actionCheckForOptions($product_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $product                = Product::findOne($product_id);
        $productOptions         = $product->getProductOptions()->with('option')->all();

        return [
            'status' => 1,
            'data' => [
                'product_options' => ArrayHelper::toArray($productOptions, [
                    'common\models\option\ProductOption' => [
                        'id',
                        'option' => function ($product_option) {
                            $option = $product_option->option;

                            return [
                                'id' => $option->id,
                                'type' => $option->type,
                                'name' => $option->content->name
                            ];
                        },
                        'values' => function ($product_option) {
                            $values = $product_option->values;
                            return ArrayHelper::toArray($values, [
                                'common\models\option\ProductOptionValue' => [
                                    'id',
                                    'option_value_id',
                                    'quantity',
                                    'price',
                                    'price_prefix',
                                    'name' => function ($value) {
                                        $option_value_id = $value->option_value_id;
                                        return OptionValue::findOne($option_value_id)->content->name;
                                    }
                                ]
                            ]);
                        }
                    ]
                ])
            ]
        ];
    }

    public function actionAddOption($product_id) {

        $product        = Product::findOne($product_id);
        $this->denyIfNotOwner($product);

        $productOption  = new ProductOption();

        $productOption->product_id = $product->id;

        if ($productOption->load(Yii::$app->request->post()) && $productOption->save()) {

            $this->redirect(['index', 'id' => $product->id]);
        }

        return $this->render('add-option', [
            'productOption' => $productOption,
            'product' => $product
        ]);
    }

    public function deleteOptionValues() {
        if (!Yii::$app->request->post('delete_value_id')) return;


        $valueIDs = Yii::$app->request->post('delete_value_id');


        foreach ($valueIDs as $valueID) {
            $value = ProductOptionValue::findOne($valueID);

            if ($value) {
                $value->delete();
            }
        }
    }

    public function actionDelete($product_id, $option_id) {
        $product = Product::findOne($product_id);
        $this->denyIfNotOwner($product);

        $option = Option::findOne($option_id);

        if (Yii::$app->request->post()) {
            $product_id = (int) Yii::$app->request->post('product_id');
            $option_id  = (int) Yii::$app->request->post('option_id');

            $productOption = ProductOption::findOne([
                'product_id'    => $product_id,
                'option_id'     => $option_id
            ]);

            if ($productOption->delete()) {
                $this->redirect(['index', 'id' => $product_id]);
            }
        }



        return $this->render('delete', [
            'product'   => $product,
            'option'    => $option
        ]);
    }
}
