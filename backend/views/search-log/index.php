<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel common\models\order\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search Log');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <h2><?= $this->title; ?></h2>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'        => '{pager}{items}{summary}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'text',
            [
                'attribute' => 'user_id',
                'headerOptions' => ['width' => '40%'],
                'value'     => function ($model) { return $model->user ? $model->user->fullname : ''; },
                'label' => Yii::t('app', 'User'),
                'filter' => Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'initValueText' => $searchModel->user ? $searchModel->user->fullname : '',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => Yii::t('app', 'Enter user name'),
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => $user_list_url,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(user) { return user.text; }'),
                            'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                        ],
                    ]
                )
            ],
            'count'
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
