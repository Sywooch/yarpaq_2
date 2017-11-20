<?php
$currency = Yii::$app->currency;
?>
<div class="basket_wrapper">

    <h2><?= Yii::t('app', 'Order details'); ?></h2>

    <div class="main_side">
        <div class="order_info">
            <div class="pair">
                <span class="_label"><?= Yii::t('app', 'Order date'); ?></span><span class="_value"><?= (new DateTime($order->created_at))->format('d.m.Y H:i') ?></span>
            </div>
            <div class="pair">
                <span class="_label"><?= Yii::t('app', 'Shipping method'); ?></span><span class="_value"><?= $order->shipping_method; ?></span>
            </div>


            <div class="order_products_info">
                <div class="pair">
                    <span class="_label"><?= Yii::t('app', 'Products'); ?></span>
                </div>

                <div class="order_products_list">
                    <?php foreach ($order->orderProducts as $orderProduct) { ?>
                    <div class="product_item">

                        <div class="order_product_name_container">
                            <span class="order_product_name"><?= $orderProduct->name; ?></span>
                            <a href="#" class="leave_feedback"></a>
                        </div>

                        <div class="pair">
                            <span class="_label"><?= Yii::t('app', 'Price'); ?></span><span class="_value">
                                <?= $currency->format($orderProduct->price, $currency->getCurrencyByCode($order->currency_code)); ?>
                            </span>
                        </div>
                        <div class="pair">
                            <span class="_label"><?= Yii::t('app', 'Quantity'); ?></span><span class="_value">
                                <?= $orderProduct->quantity; ?>
                            </span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="right_side">
        <div class="right_basket">
            <div class="order_shipping_info">
                <div class="order_shipping_info_header">
                    <?= Yii::t('app', 'Shipping address'); ?>
                </div>
                <b><?= $order->shipping_firstname . ' ' . $order->shipping_lastname; ?></b><br>
                <?= $order->shipping_address; ?>
            </div>

            <div class="order_total_info">
                <div class="totals">
                    <dl>
                        <dt><?= Yii::t('app', 'Total'); ?></dt>
                        <dd class="cart-sub-total">
                            <?= $currency->format($order->subtotal, $currency->getCurrencyByCode($order->currency_code)); ?>
                        </dd>
                        <dt><?= Yii::t('app', 'Shipping'); ?></dt>
                        <dd id="shipping-price">
                            <?= $currency->format($order->shipping_price, $currency->getCurrencyByCode($order->currency_code)); ?>
                        </dd>
                    </dl>
                    <dl>
                        <dt><?= Yii::t('app', 'Total'); ?></dt>
                        <dd class="cart-total">
                            <?= $currency->convertAndFormat($order->total, $currency->getCurrencyByCode($order->currency_code)); ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>