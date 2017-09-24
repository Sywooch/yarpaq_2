<?php

/* @var $this yii\web\View */
/* @var $model common\models\option\Option */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Add');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
