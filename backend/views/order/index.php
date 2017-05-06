<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\order\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'user_id',
            'firstname',
            'lastname',
            'email:email',
            // 'phone1',
            // 'phone2',
            // 'fax',
            // 'custom_field:ntext',
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
            // 'payment_custom_field:ntext',
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
            // 'shipping_custom_field:ntext',
            // 'shipping_method',
            // 'shipping_code',
            // 'comment:ntext',
            // 'total',
            // 'order_status_id',
            // 'language_id',
            // 'currency_id',
            // 'currency_code',
            // 'currency_value',
            // 'ip',
            // 'forwarded_ip',
            // 'user_agent',
            // 'accept_language',
            // 'created_at',
            // 'modified_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
