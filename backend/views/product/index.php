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


    <?= $this->render('_search.php', [
        'model' => $searchModel
    ]); ?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider'  => $dataProvider,
        //'filterModel' => $searchModel,
        'layout'        => '{items}{summary}{pager}',
        'columns'       => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '5%'],
            ],
            [
                'label' => Yii::t('app', 'Image'),
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
            [
                'attribute' => 'title',
                'headerOptions' => ['width' => '20%'],
            ],
            [
                'attribute' => 'model',
                'headerOptions' => ['width' => '10%'],
            ],

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
                'headerOptions' => ['width' => '5%'],
            ],
            // 'currency_id',
            [
                'attribute' => 'quantity',
                'headerOptions' => ['width' => '5%'],
            ],
            // 'stock_status_id',
            // 'weight',
            // 'weight_class_id',
            // 'length',
            // 'width',
            // 'height',
            // 'length_class_id',
            [
                'attribute' => 'status_id',
                'label'     => Yii::t('app', 'Status'),
                'value'     => 'status.name',
                'filter'    => \yii\helpers\ArrayHelper::map(\common\models\Status::find()->all(), 'id', function ($status) {
                    return Yii::t('app', $status->name);
                }),
                'headerOptions' => ['width' => '5%'],
            ],
            [
                'attribute' => 'seller_email',
                'label'     => Yii::t('app', 'E-mail'),
                'value' => 'seller.email',
                'enableSorting' => true
            ],

            // 'user_id',
            // 'manufacturer_id',
            // 'viewed',
            [
                'attribute' => 'moderated',
                'filter'    => [Yii::t('app', 'No'), Yii::t('app', 'Yes')],
                'headerOptions' => ['width' => '5%'],
            ],
            // 'moderated_at',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
