<?php

use yii\helpers\Html;
use richardfan\sortable\SortableGridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'WideBanners');
$this->params['breadcrumbs'][] = $this->title;

$dataProvider->pagination = false;
?>
<div class="slide-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create WideBanner'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'sortUrl' => Url::to(['sortItem']),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'status',
                'value' => function ($slide) {
                    if ($slide->status == 1) {
                        return Yii::t('app', 'Enabled');
                    } else {
                        return Yii::t('app', 'Disabled');
                    }
                }
            ],
            //'sort',
            //'created_at',
            // 'updated_at',
            // 'settings',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
