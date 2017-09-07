<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\order\OrderStatus;
use common\models\order\Order;

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
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options'   => [
                    'width' => '80px'
                ]
            ],

            [
                'attribute' => 'fullname',
                'value' => function ($order) {
                    return $order->firstname . ' ' . $order->lastname;
                }
            ],
            'email:email',
            // 'phone1',
            // 'phone2',
            // 'fax',
            // 'payment_firstname',
            // 'payment_lastname',
            // 'payment_company',
            // 'payment_address',
            // 'payment_city',
            // 'payment_postcode',
            // 'payment_country',
            // 'payment_country_id',
            // 'payment_zone',
            // 'payment_zone_id',
            // 'payment_method',
            // 'payment_code',
            // 'shipping_firstname',
            // 'shipping_lastname',
            // 'shipping_company',
            // 'shipping_address',
            // 'shipping_city',
            // 'shipping_postcode',
            // 'shipping_country',
            // 'shipping_country_id',
            // 'shipping_zone',
            // 'shipping_zone_id',
            // 'shipping_method',
            // 'shipping_code',
            // 'comment:ntext',
            [
                'attribute' => 'total',
                'value' => function ($order) {
                    if ($order->scenario == Order::SCENARIO_OWN) {
                        $total = 0;

                        foreach ($order->order_products as $order_product) {
                            $total += $order_product->total;
                        }

                        return $total;
                    } else {
                        return $order->total;
                    }
                }
            ],
            'total',
            [
                'attribute' => 'order_status_id',
                'filter'    => ArrayHelper::map(OrderStatus::getData(), 'order_status_id', 'name'),
                'format'    => 'raw',
                'value'     => function ($order) use ($statuses) {
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
                'format' => ['date', 'php:d.m.Y H:i:s']
            ],
            [
                'attribute' => 'modified_at',
                'format' => ['date', 'php:d.m.Y H:i:s']
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
