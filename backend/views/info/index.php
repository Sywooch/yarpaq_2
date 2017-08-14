<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\info\InfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-index">

    <div>

        <p class="pull-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app', 'Add Product'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <h2><?= Html::encode($this->title) ?></h2>

    </div>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel, // тут нечего искать
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '5%'],
            ],
            'title',
            [
                'attribute' => 'status_id',
                'label'     => Yii::t('app', 'Status'),
                'value'     => function ($info) {
                    return $info->statusTitle;
                },
                'headerOptions' => ['width' => '80px'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'headerOptions' => ['width' => '80px'],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
