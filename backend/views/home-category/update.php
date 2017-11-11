<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\appearance\HomeCategory */

$this->title = Yii::t('app', 'Update', [
    'modelClass' => 'Home Category',
]) . ': ' . $model->relatedCat->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Home Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="home-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
