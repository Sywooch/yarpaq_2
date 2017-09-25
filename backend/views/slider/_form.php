<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Language;
use kartik\file\FileInput;

$languages = Language::find()->all();

/* @var $this yii\web\View */
/* @var $model common\models\slider\Slide */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slide-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        0 => Yii::t('app', 'Disabled'),
        1 => Yii::t('app', 'Enabled')
    ]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <?php $i=1; foreach ($languages as $language) { ?>
                <li class="<?php echo $i==1 ? 'active' : '' ?>"><a href="#tab_<?php echo $i; ?>" data-toggle="tab" aria-expanded="<?php echo $i==1 ? 'true' : 'false' ?>"><?php echo $language->label; ?></a></li>
                <?php $i++; } ?>
        </ul>
        <div class="tab-content">
            <?php $i=1; foreach ($contents as $index => $content) { ?>
                <div class="tab-pane <?php echo $i==1 ? 'active' : ''; ?>" id="tab_<?php echo $content->language_id; ?>">

                    <?= $form->field($content, "[$index]link")->textInput([
                        'class' => 'form-control',
                    ]);


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

                    if ($content->web_name != '') {
                        $uploaderPluginOptions['initialPreview'] = $content->url;
                        $uploaderPluginOptions['initialPreviewConfig'][] = [
                            'caption' => $content->src_name,
                            'width' => "120px",
                            'key' => 1
                        ];
                    }

                    echo $form->field($content, "[$index]image")->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => $uploaderPluginOptions
                    ])->label(Yii::t('app', 'Image'));
                    ?>
                    <input type="hidden" name="gallery_sort" value="<?= $content->src_name; ?>">
                </div>
                <!-- /.tab-pane -->

            <?php $i++; } ?>
        </div>
        <!-- /.tab-content -->

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
