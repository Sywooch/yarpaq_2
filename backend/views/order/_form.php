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
                    ])->label(Yii::t('app', 'User'));

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
                    <?= $form->field($order, 'phone1')->textInput(['maxlength' => true])->label(Yii::t('app', 'Phone') . ' 1') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($order, 'phone2')->textInput(['maxlength' => true])->label(Yii::t('app', 'Phone') . ' 2') ?>
                </div>
            </div>
        </div>
    </div>


    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Products'); ?></h3>
        </div>

        <div class="box-body">

            <table class="table table-bordered table-striped" id="productsTable">
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
                    foreach ($order->orderProducts as $orderProduct) {
                        $product = $orderProduct->product;
                        ?>
                    <tr>
                        <td><?=$num?>.</td>
                        <td>

                            <?php if ($product) { ?>
                                <a target="_blank" href="<?= Url::to(['product/update', 'id' => $product->id]); ?>"><?= $orderProduct->name; ?></a>
                            <?php } else { ?>
                                <?= $orderProduct->name; ?>
                            <?php } ?>

                            <?php foreach ($orderProduct->orderProductOptions as $orderProductOption) { ?>
                                <small> &mdash; <?= $orderProductOption->name . ': '. $orderProductOption->value; ?></small>
                            <?php } ?>

                            <?php if ($product) { ?>
                            <br>Kod: <?= $product->id; ?>
                            <?php } ?>
                        </td>
                        <td><?= $orderProduct->model; ?></td>
                        <td><?= $orderProduct->quantity; ?></td>
                        <td><?= $orderProduct->price; ?></td>
                        <td><?= $orderProduct->total; ?></td>

                        <td>
                            <button
                                type="button"
                                class="btn btn-danger btn-xs"
                                order-product-delete-btn
                                data-name="<?= htmlentities($orderProduct->model); ?>"
                                data-id="<?= $orderProduct->id; ?>"
                            ><?= Yii::t('app', 'Delete from order'); ?></button></td>
                    </tr>

                    <?php $num++; } ?>

                </tbody>
            </table>


            <!-- Order Product Delete Confirmation Modal -->

            <div id="orderDeleteModal" class="modal fade in">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title"><?= Yii::t('app', 'Removing product from order'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                <?= Yii::t('app', 'Are you sure you want to remove this product from the order: '); ?>
                            </p>

                            <p class="lead" order-product-name></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= Yii::t('app', 'Close'); ?></button>
                            <button type="button" class="btn btn-primary" confirm-btn data-id="" data-loading-text="<?= Yii::t('app', 'Loading...'); ?>"><?= Yii::t('app', 'Confirm'); ?></button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!-- ### Order Product Delete Confirmation Modal -->

            <div id="orderProductAdd">
                <div class="row">
                    <div class="col-md-6">

                        <h4><?= Yii::t('app', 'Add'); ?></h4>

                        <?php

                        echo $form->field($orderProductAddForm, 'product_id')->widget(Select2::className(), [
                            'id' => 'selectAddOrderProduct',
                            'name' => 'add_product',
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => Url::to(['product/list']),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],
                        ])->label(Yii::t('app', 'Product'));

                        ?>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($orderProductAddForm, 'quantity')->textInput(['maxlength' => true])
                        -> label(Yii::t('app', 'Quantity'))?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" id="options">

                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-info btn-sm order-product-add-btn" data-id="<?= $order->id; ?>"><?= Yii::t('app', 'Add'); ?></button>
                </div>
            </div>

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
                        ->dropDownList([], [
                            'data-default-id' => $order->payment_zone_id
                        ]) ?>
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
                        ->dropDownList([], [
                            'data-default-id' => $order->shipping_zone_id
                        ]) ?>
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
                    <label><?= Yii::t('app', 'Payment method'); ?>:</label><br>
                    <?= $order->payment_method; ?>
                </div>

                <div class="col-md-6">
                    <label><?= Yii::t('app', 'Shipping method'); ?>:</label><br>
                    <?= $order->shipping_method; ?>
                </div>
            </div>

            <?= $form->field($order, 'comment')->textarea(['rows' => 6]) ?>

            <?= $form->field($order, 'order_status_id')
                ->dropDownList(ArrayHelper::map(OrderStatus::getData(), 'order_status_id', 'name')); ?>
        </div>
    </div>

    <div class="form-group pull-right">
        <?= Html::a(Yii::t('app', 'Delete'), ['order/delete', 'id' => $order->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($order->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $order->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
