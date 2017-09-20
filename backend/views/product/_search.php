<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Product;
use common\models\category\Category;
use kartik\daterange\DateRangePicker;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id'); ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'title') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'model') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'price') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'quantity') ?>
        </div>




    </div>

    <div class="row">

        <div class="col-md-2">
            <?= $form->field($model, 'status_id')->dropDownList([
                ''  => Yii::t('app', 'All'),
                Product::STATUS_ACTIVE   => Yii::t('app', 'Active'),
                Product::STATUS_INACTIVE => Yii::t('app', 'Inactive'),
            ]) ?>
        </div>

        <?php if (User::hasPermission('view_all_products')) { ?>
        <div class="col-md-2">
            <?= $form->field($model, 'seller_email') ?>
        </div>
        <?php } ?>

        <div class="col-md-2">
            <?= $form->field($model, 'moderated')->dropDownList([
                ''  => Yii::t('app', 'All'),
                '0' => Yii::t('app', 'No'),
                '1' => Yii::t('app', 'Yes')
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'created_at')->widget(DateRangePicker::className(), [
                'model' => $model,
                'attribute' => 'created_at',
                'convertFormat' => true,
                'pluginOptions' => [
                    'timePicker' => false,
                    'timePickerIncrement' => 30,
                    'locale'=>[
                        'format'=>'Y-m-d'
                    ]
                ],
                'autoUpdateOnInit' => false
            ]) ?>
        </div>

        <div class="col-md-2">
            <?php
            $categories = [];
            $categories[''] = Yii::t('app', 'All');
            $categories = array_merge($categories, ArrayHelper::map(Category::find()
                ->where(['>', 'parent_id', 0])
                ->orderBy('lft')
                ->all(), 'id', function ($category) {
                return str_repeat(' - ', $category->depth-1).$category->title;
            }));


            //ksort($categories);
            ?>
            <?= $form->field($model, 'category')->dropDownList($categories); ?>
        </div>
    </div>



    <?php // echo $form->field($model, 'sku') ?>

    <?php // echo $form->field($model, 'upc') ?>

    <?php // echo $form->field($model, 'ean') ?>

    <?php // echo $form->field($model, 'jan') ?>

    <?php // echo $form->field($model, 'isbn') ?>

    <?php // echo $form->field($model, 'mpn') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'condition_id') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'stock_status_id') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'weight_class_id') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'width') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'length_class_id') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'manufacturer_id') ?>

    <?php // echo $form->field($model, 'viewed') ?>

    <?php // echo $form->field($model, 'moderated') ?>

    <?php // echo $form->field($model, 'moderated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
