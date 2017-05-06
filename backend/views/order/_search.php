<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\order\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone1') ?>

    <?php // echo $form->field($model, 'phone2') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'custom_field') ?>

    <?php // echo $form->field($model, 'payment_firstname') ?>

    <?php // echo $form->field($model, 'payment_lastname') ?>

    <?php // echo $form->field($model, 'payment_company') ?>

    <?php // echo $form->field($model, 'payment_address') ?>

    <?php // echo $form->field($model, 'payment_city') ?>

    <?php // echo $form->field($model, 'payment_postcode') ?>

    <?php // echo $form->field($model, 'payment_country') ?>

    <?php // echo $form->field($model, 'payment_country_id') ?>

    <?php // echo $form->field($model, 'payment_zone') ?>

    <?php // echo $form->field($model, 'payment_zone_id') ?>

    <?php // echo $form->field($model, 'payment_address_format') ?>

    <?php // echo $form->field($model, 'payment_custom_field') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'payment_code') ?>

    <?php // echo $form->field($model, 'shipping_firstname') ?>

    <?php // echo $form->field($model, 'shipping_lastname') ?>

    <?php // echo $form->field($model, 'shipping_company') ?>

    <?php // echo $form->field($model, 'shipping_address') ?>

    <?php // echo $form->field($model, 'shipping_city') ?>

    <?php // echo $form->field($model, 'shipping_postcode') ?>

    <?php // echo $form->field($model, 'shipping_country') ?>

    <?php // echo $form->field($model, 'shipping_country_id') ?>

    <?php // echo $form->field($model, 'shipping_zone') ?>

    <?php // echo $form->field($model, 'shipping_zone_id') ?>

    <?php // echo $form->field($model, 'shipping_address_format') ?>

    <?php // echo $form->field($model, 'shipping_custom_field') ?>

    <?php // echo $form->field($model, 'shipping_method') ?>

    <?php // echo $form->field($model, 'shipping_code') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'order_status_id') ?>

    <?php // echo $form->field($model, 'language_id') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'currency_code') ?>

    <?php // echo $form->field($model, 'currency_value') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'forwarded_ip') ?>

    <?php // echo $form->field($model, 'user_agent') ?>

    <?php // echo $form->field($model, 'accept_language') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
