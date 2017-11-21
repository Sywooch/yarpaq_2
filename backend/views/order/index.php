<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\order\OrderStatus;
use common\models\User;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\order\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;


$statuses = OrderStatus::find()
    ->andWhere(['language_id' => \common\models\Language::getCurrent()->id])
    ->all();
?>
<div class="order-index">
    <h2><?= $this->title; ?></h2>

    <?php if (false && \common\models\User::hasPermission('create_order')) { ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'        => '{pager}{items}{summary}{pager}',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options'   => [
                    'width' => '80px'
                ],
                'label' => 'ID'
            ],

            [
                'attribute' => 'fullname',
                'label' => Yii::t('app', 'Fullname'),
                'value' => function ($order) {
                    return $order->firstname . ' ' . $order->lastname;
                }
            ],
            'email:email',

            [
                'attribute' => 'products',
                'format' => 'raw',
                'value' => function ($order) {
                    $value = '';

                    foreach ($order->orderProducts as $orderProduct) {
                        $value .= '- '.$orderProduct->name.'<br>';
                    }

                    return $value;
                },
            ],

            [
                'attribute' => 'converted_total',
                'value' => function ($order) {
                    if (!User::hasPermission('view_all_orders')) {
                        $total = 0;

                        foreach ($order->orderProducts as $order_product) {
                            $product = $order_product->product;
                            if ($product && $product->user_id == User::getCurrentUser()->id) {
                                $total += $order_product->total * $order->currency_value;
                            }
                        }

                        return $total;
                    } else {
                        return $order->total * $order->currency_value;
                    }
                }
            ],
            [
                'attribute' => 'order_status_id',
                'filter'    => ArrayHelper::map(OrderStatus::getData(), 'order_status_id', 'name'),
                'format'    => 'raw',
                'value'     => function ($order) use ($statuses) {
                    if (!User::hasPermission('view_all_orders')) {
                        return $order->status->name;
                    }

                    $html = '<select data-order-id="'.$order->id.'" class="order-status-change-select">';

                    foreach ($statuses as $status) {
                        $html .= '<option '.($status->order_status_id == $order->order_status_id ? 'selected' : '').' value="'.$status->order_status_id.'">'.$status->name.'</option>';
                    }

                    $html .= '</select>';

                    return $html;
                },
                'contentOptions' => ['style'=>'min-width: 120px;']
            ],


            // 'language_id',
            // 'currency_id',
            // 'currency_code',
            // 'currency_value',
            // 'ip',
            // 'forwarded_ip',
            // 'user_agent',
            // 'accept_language',
            [
                'attribute' => 'created_at',
                'filter' => DateRangePicker::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'timePicker' => false,
                            'timePickerIncrement' => 30,
                            'locale'=>[
                                'format'=>'Y-m-d'
                            ]
                        ],
                        'autoUpdateOnInit' => false
                    ]
                )
            ],
//            [
//                'attribute' => 'modified_at',
//                'filter' => DateRangePicker::widget(
//                    [
//                        'model' => $searchModel,
//                        'attribute' => 'modified_at',
//                        'convertFormat' => true,
//                        'pluginOptions' => [
//                            'timePicker' => false,
//                            'timePickerIncrement' => 30,
//                            'locale'=>[
//                                'format'=>'Y-m-d'
//                            ]
//                        ],
//                        'autoUpdateOnInit' => false
//                    ]
//                )
//            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'visible' => User::hasPermission('view_all_orders')
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'visible' => !User::hasPermission('view_all_orders')
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
