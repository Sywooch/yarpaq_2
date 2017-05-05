<?php

/* @var $this yii\web\View */
/* @var $model common\models\option\Option */

$this->title = Yii::t('app', 'Create Option');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
