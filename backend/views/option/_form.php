<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\option\Option */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="option-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'class' => 'form-control col-lg']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <?php $i=0; foreach (\common\models\Language::find()->all() as $l) { ?>
                    <li class="<?php echo !$i ? 'active' : '' ?>"><a href="#lang_<?php echo $l->id; ?>" data-toggle="tab"><?php echo $l->label; ?></a></li>
                    <?php $i++; } ?>
                </ul>
                <div class="tab-content">
                    <?php $i=0; foreach ($model->contents as $content) { ?>

                        <div class="tab-pane <?php echo !$i ? 'active' : '' ?>" id="lang_<?php echo $content->language_id; ?>">
                            <?= $form->field($content, '['.$content->language_id.']name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <!-- /.tab-pane -->

                    <?php $i++; } ?>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
