<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use common\models\User;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\models\Country;
use common\models\Zone;
use common\models\order\OrderStatus;
use common\models\payment\PaymentMethod;
use common\models\shipping\ShippingMethod;
use yii\helpers\ArrayHelper;

$order = $model;

/* @var $this yii\web\View */
/* @var $order common\models\order\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Customer info'); ?></h3>
        </div>

        <div class="box-body">
            <div class="row">

                <div class="col-md-4">

                    <?php

                    $url = Url::to(['user/user-list']);

                    // Get the initial user fullname and email
                    $user_fullname = '';
                    if (!empty($order->user_id)) {
                        $user = User::findOne($order->user_id);
                        $user_fullname = $user->fullname . ' ('.$user->email.')';
                    }

                    echo $form->field($order, 'user_id')->widget(Select2::classname(), [
                        'initValueText' => $user_fullname, // set the initial display text
                        'options' => [
                            'placeholder' => 'Search for a user ...',
                            'data-info-url' => Url::to(['user/info'])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(user) { return user.text; }'),
                            'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                        ],

                        'pluginEvents' => [
                            "change" => "function(e) { onChangeOrderUser(e); }",
                        ]
                    ]);

                    ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($order, 'firstname')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($order, 'lastname')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($order, 'email')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($order, 'phone1')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($order, 'phone2')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Products'); ?></h3>
        </div>

        <div class="box-body">

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th><?= Yii::t('app', 'Product'); ?></th>
                        <th><?= Yii::t('app', 'Model'); ?></th>
                        <th><?= Yii::t('app', 'Quantity'); ?></th>
                        <th><?= Yii::t('app', 'Price'); ?></th>
                        <th><?= Yii::t('app', 'Total'); ?></th>
                        <th style="width: 40px"></th>
                    </tr>

                    <?php
                    $num = 1;
                    foreach ($order->orderProducts as $orderProduct) { ?>
                    <tr>
                        <td><?=$num?>.</td>
                        <td><?= $orderProduct->product->title; ?></td>
                        <td><?= $orderProduct->product->model; ?></td>
                        <td><?= $orderProduct->quantity; ?></td>
                        <td><?= $orderProduct->price; ?></td>
                        <td><?= $orderProduct->total; ?></td>

                        <td><button type="button" class="btn btn-danger btn-xs"><?= Yii::t('app', 'Delete from order'); ?></button></td>
                    </tr>

                    <?php $num++; } ?>

                </tbody>
            </table>

        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Payment info'); ?></h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($order, 'payment_firstname')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'payment_lastname')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'payment_company')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'payment_city')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($order, 'payment_address')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'payment_postcode')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'payment_country_id')
                        ->dropDownList(ArrayHelper::map(Country::find()->all(), 'id', 'name'), [
                            'data-region-element-id' => 'order-payment_zone_id',
                            'data-url' => Url::to(['region/regions-by-country'])
                        ]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'payment_zone_id')
                        ->dropDownList(ArrayHelper::map(Zone::find()->all(), 'id', 'name')) ?>

                </div>
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Shipping info'); ?></h3>
        </div>

        <div class="box-body">

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_firstname')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_lastname')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_company')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_city')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_address')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_postcode')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_country_id')
                        ->dropDownList(ArrayHelper::map(Country::find()->all(), 'id', 'name'), [
                            'data-region-element-id' => 'order-shipping_zone_id',
                            'data-url' => Url::to(['region/regions-by-country'])
                        ]);
                    ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($order, 'shipping_zone_id')
                        ->dropDownList(ArrayHelper::map(Zone::find()->all(), 'id', 'name')) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Totals'); ?></h3>
        </div>

        <div class="box-body">

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($order, 'payment_method')
                        ->dropDownList(ArrayHelper::map(PaymentMethod::find()->all(), 'id', 'name')); ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($order, 'shipping_method')
                        ->dropDownList(ArrayHelper::map(ShippingMethod::find()->all(), 'id', 'name')); ?>
                </div>
            </div>

            <?= $form->field($order, 'comment')->textarea(['rows' => 6]) ?>

            <?= $form->field($order, 'order_status_id')
                ->dropDownList(ArrayHelper::map(OrderStatus::getData(), 'order_status_id', 'name')); ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($order->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $order->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
