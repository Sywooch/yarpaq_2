<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\category\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories -> Clear cache');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <?= $success ? 'Ok' : 'Error'; ?>

</div>