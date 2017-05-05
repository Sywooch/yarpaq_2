<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\option\Option */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Option',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="option-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
