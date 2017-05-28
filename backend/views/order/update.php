<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\order\Order */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Order',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-update">

    <?= $this->render('_form', [
        'model' => $model,
        'orderProductAddForm' => $orderProductAddForm
    ]) ?>

</div>
