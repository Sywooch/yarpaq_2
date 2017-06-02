<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\category\Category */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Category',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="page-update">

    <?php
    echo $this->render('_update_form', [
        'model' => $model,
        'parent' => $parent,
        'languages' => $languages,
        'contents' => $contents
    ]);
    ?>

</div>
