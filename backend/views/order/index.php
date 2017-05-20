<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\order\OrderStatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\order\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'firstname',
            'lastname',
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
            // 'payment_address_format:ntext',
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
            // 'shipping_address_format:ntext',
            // 'shipping_method',
            // 'shipping_code',
            // 'comment:ntext',
            'total',
            [
                'attribute' => 'order_status_id',
                'filter'    => ArrayHelper::map(OrderStatus::getData(), 'order_status_id', 'name'),
                'value'     => 'status.name',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
