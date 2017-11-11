<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\file\FileInput;
use common\models\appearance\HomeCategory;

/* @var $this yii\web\View */
/* @var $model common\models\appearance\HomeCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="home-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <h3><?= Yii::t('app', 'Category'); ?></h3>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'related_cat_id')->widget(Select2::classname(), [
                'initValueText' => $model->relatedCat ? $model->relatedCat->title : '',
                'pluginOptions' => [
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['category/list?full=true']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    'tags' => true,
                    'tokenSeparators' => [','],
                    'maximumInputLength' => 10,
                ],
            ])->label(Yii::t('app', 'Category')); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([
                HomeCategory::STATUS_INACTIVE => Yii::t('app', 'Disabled'),
                HomeCategory::STATUS_ACTIVE => Yii::t('app', 'Active')
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'bg_color')->textInput(); ?>
        </div>
    </div>

    <h3><?= Yii::t('app', 'Images'); ?></h3>


    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'product_id_1')->widget(Select2::classname(), [
                'initValueText' => $model->product1 ? $model->product1->title : '',
                'pluginOptions' => [
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['product/list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    'tags' => true,
                    'tokenSeparators' => [','],
                    'maximumInputLength' => 10,
                ],
            ])->label(Yii::t('app', 'Product')); ?>

            <?php
            $uploaderPluginOptions = [
                'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                'showUpload' => false,
                'showRemove' => false,
                'deleteUrl' => \yii\helpers\Url::to(['slider/image-delete']),
                'initialPreviewAsData' => true,
                'overwriteInitial' => false,
                'initialPreview' => [],
                'initialPreviewConfig' => []
            ];

            if ($model->web_name_1 != '') {
                $uploaderPluginOptions['initialPreview'] = $model->url1;
                $uploaderPluginOptions['initialPreviewConfig'][] = [
                    'caption' => $model->src_name_1,
                    'width' => "120px",
                    'key' => 1
                ];
            }

            echo $form->field($model, "image1")->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => $uploaderPluginOptions
            ])->label(Yii::t('app', 'Image')); ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'product_id_2')->widget(Select2::classname(), [
                'initValueText' => $model->product2 ? $model->product2->title : '',
                'pluginOptions' => [
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['product/list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    'tags' => true,
                    'tokenSeparators' => [','],
                    'maximumInputLength' => 10,
                ],
            ])->label(Yii::t('app', 'Product')); ?>

            <?php
            $uploaderPluginOptions = [
                'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                'showUpload' => false,
                'showRemove' => false,
                'deleteUrl' => \yii\helpers\Url::to(['slider/image-delete']),
                'initialPreviewAsData' => true,
                'overwriteInitial' => false,
                'initialPreview' => [],
                'initialPreviewConfig' => []
            ];

            if ($model->web_name_2 != '') {
                $uploaderPluginOptions['initialPreview'] = $model->url2;
                $uploaderPluginOptions['initialPreviewConfig'][] = [
                    'caption' => $model->src_name_2,
                    'width' => "120px",
                    'key' => 2
                ];
            }

            echo $form->field($model, "image2")->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => $uploaderPluginOptions
            ])->label(Yii::t('app', 'Image')); ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'product_id_3')->widget(Select2::classname(), [
                'initValueText' => $model->product3 ? $model->product3->title : '',
                'pluginOptions' => [
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['product/list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    'tags' => true,
                    'tokenSeparators' => [','],
                    'maximumInputLength' => 10,
                ],
            ])->label(Yii::t('app', 'Product')); ?>

            <?php
            $uploaderPluginOptions = [
                'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                'showUpload' => false,
                'showRemove' => false,
                'deleteUrl' => \yii\helpers\Url::to(['slider/image-delete']),
                'initialPreviewAsData' => true,
                'overwriteInitial' => false,
                'initialPreview' => [],
                'initialPreviewConfig' => []
            ];

            if ($model->web_name_3 != '') {
                $uploaderPluginOptions['initialPreview'] = $model->url3;
                $uploaderPluginOptions['initialPreviewConfig'][] = [
                    'caption' => $model->src_name_3,
                    'width' => "120px",
                    'key' => 3
                ];
            }

            echo $form->field($model, "image3")->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => $uploaderPluginOptions
            ])->label(Yii::t('app', 'Image')); ?>
        </div>


    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
