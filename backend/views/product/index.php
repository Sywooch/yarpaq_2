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
    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => 80]
            ],
            [
                'format' => 'html',
                'value' => function($product) {
                    $gallery = $product->gallery;

                    if (count($gallery)) {
                        $url = $gallery[0]->url;
                    } else {
                        $url = Yii::$app->params['emptyImgUrl'];
                    }

                    return Html::img($url, ['width'=>'50']);
                },
            ],
            'title',
            'model',
//            'sku',
//            'upc',
//            'ean',
            // 'jan',
            // 'isbn',
            // 'mpn',
            // 'location',
            // 'condition_id',
            [
                'attribute' => 'price',
                'contentOptions' => ['width' => 100]
            ],
            // 'currency_id',
            [
                'attribute' => 'quantity',
                'contentOptions' => ['width' => 50]
            ],
            // 'stock_status_id',
            // 'weight',
            // 'weight_class_id',
            // 'length',
            // 'width',
            // 'height',
            // 'length_class_id',
            'status.name',
            'seller.email',
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
