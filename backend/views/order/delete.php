<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\order\Order */

$this->title = Yii::t('app', 'Delete Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <?php $form = ActiveForm::begin(['action' => ['order/confirm-delete', 'id' => $order->id], 'method' => 'post']); ?>

    <?= Yii::t('app', 'Are you sure you want to delete this order? '); ?>

    <br><br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Confirm'), ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
