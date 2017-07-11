<?php

namespace backend\controllers;

use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\Product;
use Yii;
use webvimark\components\AdminDefaultController;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * ProductOptionController implements the CRUD actions for Product model.
 */
class ProductOptionController extends AdminDefaultController
{
    public function actionIndex($id)
    {
        $product = Product::findOne($id);

        return $this->render('index', [
            'model' => $product
        ]);
    }

    public function actionUpdate($id) {
        $product = Product::findOne($id);


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

    public function deleteOptionValues() {
        if (!Yii::$app->request->post('delete_value_id')) return;


        $valueIDs = Yii::$app->request->post('delete_value_id');


        foreach ($valueIDs as $valueID) {
            $value = ProductOptionValue::findOne($valueID);
            $value->delete();
        }
    }
}
