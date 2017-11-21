<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\review\Review */

$this->title = \common\models\Product::findOne($model->product_id)->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_id',
            'seller_id',
            'product_id',
            'review:ntext',
            'post_date',
            'stars',
            'status',
        ],
    ]) ?>

    <?= Html::a(Yii::t('app', 'Confirm'), Url::to(['review/activate', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>
    <?= Html::a(Yii::t('app', 'Reject'), Url::to(['review/deactivate', 'id' => $model->id]), ['class' => 'btn btn-danger']); ?>

</div>
