<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\order\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$order = $model;
?>
<div class="order-view">

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






    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Customer info'); ?></h3>
        </div>

        <div class="box-body">
            <div class="row">

                <div class="col-md-6 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Fullname'); ?></label>
                    <div>
                        <?= $order->firstname; ?> <?= $order->lastname; ?>
                    </div>
                </div>

                <div class="col-md-6 m-b-20">
                    <label class="control-label">Email</label>
                    <div>
                        <?= $order->email; ?>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Phone'); ?> 1</label>
                    <div>
                        <?= $order->phone1; ?>
                    </div>

                </div>
                <div class="col-md-6 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Phone'); ?> 2</label>
                    <div>
                        <?= $order->phone2; ?>
                    </div>
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
                </tr>

                <?php
                $num = 1;
                foreach ($order->orderProducts as $orderProduct) {
                    $product = $orderProduct->product;

                    if (($product && User::getCurrentUser()->id != $product->user_id && !User::hasPermission('view_any_order') ) || !$product) {
                        continue;
                    }
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

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Firstname'); ?></label>
                    <div>
                        <?= $order->payment_firstname; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Lastname'); ?></label>
                    <div>
                        <?= $order->payment_lastname; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Company'); ?></label>
                    <div>
                        <?= $order->payment_company; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'City'); ?></label>
                    <div>
                        <?= $order->payment_city; ?>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Address'); ?></label>
                    <div>
                        <?= $order->payment_address; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Postcode'); ?></label>
                    <div>
                        <?= $order->payment_postcode; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Country'); ?></label>
                    <div>
                        <?= $order->paymentCountry->name; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Zone'); ?></label>
                    <div>
                        <?= $order->paymentZone->name; ?>
                    </div>
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

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Firstname'); ?></label>
                    <div>
                        <?= $order->shipping_firstname; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Lastname'); ?></label>
                    <div>
                        <?= $order->shipping_lastname; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Company'); ?></label>
                    <div>
                        <?= $order->shipping_company; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'City'); ?></label>
                    <div>
                        <?= $order->shipping_city; ?>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Address'); ?></label>
                    <div>
                        <?= $order->shipping_address; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Postcode'); ?></label>
                    <div>
                        <?= $order->shipping_postcode; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Country'); ?></label>
                    <div>
                        <?= $order->shippingCountry->name; ?>
                    </div>
                </div>

                <div class="col-md-3 m-b-20">
                    <label class="control-label"><?= Yii::t('app', 'Zone'); ?></label>
                    <div>
                        <?= $order->shippingZone->name; ?>
                    </div>
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

                <div class="col-md-6 m-b-20">
                    <label><?= Yii::t('app', 'Payment method'); ?>:</label><br>
                    <?= $order->payment_method; ?>
                </div>

                <div class="col-md-6 m-b-20">
                    <label><?= Yii::t('app', 'Shipping method'); ?>:</label><br>
                    <?= $order->shipping_method; ?>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12 m-b-20">
                    <label><?= Yii::t('app', 'Comment'); ?>:</label><br>
                    <?= $order->comment; ?>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12 m-b-20">
                    <label><?= Yii::t('app', 'Status'); ?>:</label><br>
                    <?= $order->status->name; ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group pull-right">
        <?= Html::a(Yii::t('app', 'Delete'), ['order/delete', 'id' => $order->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($order->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $order->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


</div>
