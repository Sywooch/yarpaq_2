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
        <div class="col-md-12">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'class' => 'form-control col-lg']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
                            <?= $form->field($content, '['.$content->language_id.']name')->textInput(['maxlength' => true])
                                ->label(Yii::t('app', 'Name')) ?>
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

    <div class="box box-solid">
        <div class="box-header with-border">
            <button type="button" class="btn btn-primary btn-sm pull-right">
                <?= Yii::t('app', 'Add') ?>
            </button>
            <h3 class="box-title"><?= Yii::t('app', 'Option values') ?></h3>
        </div>

        <div class="box-body">

            <?php foreach ($model->values as $value) { ?>
            <div class="row">

                <div class="col-md-1">
                    <p class="text-muted">#<?php echo $value->id; ?></p>
                </div>

                <?php foreach ($value->contents as $content) { ?>
                <div class="col-md-2">
                    <?php
                    echo $form->field($content, '['.$content->option_value_id.']name')
                        ->textInput(['class' => 'form-control input-sm'])
                        ->label(false);
                    ?>
                </div>
                <?php } ?>

                <div class="col-md-3">
                    <?php if ($value->image) { ?>
                        <img src="<?= $value->url; ?>" width="30">
                    <?php } ?>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm pull-right">
                        <?= Yii::t('app', 'Delete') ?>
                    </button>
                </div>

            </div>
            <?php } ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
