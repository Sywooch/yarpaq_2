<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\category\Category */
/* @var $parent common\models\category\Category */
/* @var $content common\models\category\CategoryContent */

$this->title = Yii::t('app', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];

?>
<div class="page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_update_form', [
        'model' => $model,
        'parent' => $parent,
        'languages' => $languages,
        'contents' => $contents
    ]) ?>

</div>
