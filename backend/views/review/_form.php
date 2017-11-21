<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\review\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'seller_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'post_date')->textInput() ?>

    <?= $form->field($model, 'stars')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
