<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;


/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div>

        <p class="pull-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app', 'Add Product'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <h2><?= $this->title; ?></h2>

    </div>



    <?= $this->render('_search.php', [
        'model' => $searchModel
    ]); ?>

    <?=Html::beginForm(['product/bulk'], 'post');?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider'  => $dataProvider,
        //'filterModel' => $searchModel,
        'layout'        => '{items}{summary}{pager}',
        'columns'       => [
            ['class' => \yii\grid\CheckboxColumn::className()],
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
                'attribute'     => 'seller_email',
                'label'         => Yii::t('app', 'E-mail'),
                'format'        => 'raw',
                'value'         => function ($product) {
                    return Html::a(
                        $product->seller->email,
                        \yii\helpers\Url::to(['user-management/user/view', 'id' => $product->seller->id]),
                        [
                            'title' => Yii::t('app', 'Seller'),
                            'target' => '_blank',
                            'data-pjax' => '0',
                        ]
                    );
                },
                'enableSorting' => true,
                'visible'       => User::hasRole('view_all_products')
            ],

            // 'user_id',
            // 'manufacturer_id',
            // 'viewed',
            [
                'attribute' => 'moderated',
                'filter'    => [Yii::t('app', 'No'), Yii::t('app', 'Yes')],
                'headerOptions' => ['width' => '5%'],
                'value' => function ($model) {
                    return $model->moderated ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                }
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

    <?=Html::dropDownList('action', '', [
        '' => 'Action: ',
        'delete' => 'Delete',
    ],
        ['class'=>'dropdown'])?>
    <?=Html::submitButton('Send', ['class' => 'btn btn-info',]);?>

    <?php Pjax::end(); ?></div>
