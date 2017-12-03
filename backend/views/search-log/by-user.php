<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\order\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search Log'). ': '. Yii::t('app', 'By user');
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
            [
                'attribute' => 'user_id',
                'headerOptions' => ['width' => '40%'],
                'format' => 'raw',
                'value'     => function ($model) {
                    return $model->user ? '<a href="'.Url::to(['user-management/user/update', 'id' => $model->user_id]).'">'.$model->user->fullname.'</a>' : '';
                },
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
            'text',
            [
                'attribute' => 'no_result',
                'label' => Yii::t('app', 'Results'),
                'filter' => [
                    '1' => Yii::t('app', 'No result'),
                    '0' => Yii::t('app', 'Results found'),
                ],
                'value' => function ($query) {
                    return $query->no_result === 1 ? Yii::t('app', 'No result') : Yii::t('app', 'Results found');
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d M Y'],
                'label' => Yii::t('app', 'Created At')
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
