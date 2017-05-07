<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\order\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'firstname',
            'lastname',
            'email:email',
            'phone1',
            'phone2',
            'fax',
            'custom_field:ntext',
            'payment_firstname',
            'payment_lastname',
            'payment_company',
            'payment_address',
            'payment_city',
            'payment_postcode',
            'payment_country',
            'payment_country_id',
            'payment_zone',
            'payment_zone_id',
            'payment_address_format:ntext',
            'payment_custom_field:ntext',
            'payment_method',
            'payment_code',
            'shipping_firstname',
            'shipping_lastname',
            'shipping_company',
            'shipping_address',
            'shipping_city',
            'shipping_postcode',
            'shipping_country',
            'shipping_country_id',
            'shipping_zone',
            'shipping_zone_id',
            'shipping_address_format:ntext',
            'shipping_custom_field:ntext',
            'shipping_method',
            'shipping_code',
            'comment:ntext',
            'total',
            'order_status_id',
            'language_id',
            'currency_id',
            'currency_code',
            'currency_value',
            'ip',
            'forwarded_ip',
            'user_agent',
            'accept_language',
            'created_at',
            'modified_at',
        ],
    ]) ?>

</div>
