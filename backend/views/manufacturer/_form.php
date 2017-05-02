<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacturer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manufacturer-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php

    $uploaderPluginOptions = [
        'allowedFileExtensions' => ['jpg', 'gif', 'png'],
        'showUpload' => false,
        'showRemove' => false,

        'deleteUrl' => \yii\helpers\Url::to(['manufacturer/image-delete']),


        'initialPreviewAsData' => true,
        'overwriteInitial' => false,
        'initialCaption' => "Upload image",
        'initialPreview' => [],
        'initialPreviewConfig' => []
    ];

    if ($model->image_web_filename != '') {
        $uploaderPluginOptions['initialPreview'] = $model->imageUrl;
        $uploaderPluginOptions['initialPreviewConfig'][] = ['caption' => $model->image_src_filename, 'width' => "120px", 'key' => 1];
    }

    echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => $uploaderPluginOptions
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
