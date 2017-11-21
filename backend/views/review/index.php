<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\review\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'customer_id',
            'seller_id',
            'product_id',
            [
                'attribute' => 'review',
                'value' => function ($review) {
                    return mb_substr($review->review, 0, 40);
                }
            ],
            //'post_date',
             'stars',
             'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
