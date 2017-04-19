<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'model',
            'sku',
            'upc',
            'ean',
            // 'jan',
            // 'isbn',
            // 'mpn',
            // 'location',
            // 'condition_id',
            // 'price',
            // 'currency_id',
            // 'quantity',
            // 'stock_status_id',
            // 'weight',
            // 'weight_class_id',
            // 'length',
            // 'width',
            // 'height',
            // 'length_class_id',
            // 'status_id',
            // 'user_id',
            // 'manufacturer_id',
            // 'viewed',
            // 'moderated',
            // 'moderated_at',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
