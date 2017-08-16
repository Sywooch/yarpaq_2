<?php

use common\models\Product;
use common\models\info\Info;
use yii\helpers\Url;

$currency = Yii::$app->currency;
?>
<div class="basket_wrapper">
    <div class="main_side">
        <div class="basket_items">
            <header>
                <h3><?= Yii::t('app', 'Cart'); ?></h3>
            </header>
            <?php if ($cart->hasProducts()) { ?>
                <div class="basket_list">
                    <?php
                    foreach ($cart->getProducts() as $key => $product) {
                        $product_object = Product::findOne($product['product_id']); ?>
                        <article>
                            <div class="image">
                                <a href="<?= $product_object->url; ?>">
                                    <img src="<?= $product['image']; ?>" alt="">
                                </a>
                            </div>
                            <div class="inner">
                                <div class="price">
                                    <?= $currency->convertAndFormat($product['price'], $product_object->currency); ?>
                                </div>
                                <p><?= $product['title']; ?></p>
                                <div class="params">

                                    <form action="/cart/add" method="post">

                                        <input class="form-token" type="hidden"
                                               name="<?=Yii::$app->request->csrfParam?>"
                                               value="<?=Yii::$app->request->csrfToken?>"/>

                                        <input type="hidden"
                                               name="AddToCartForm[productId]"
                                               value="<?=$product_object->id;?>">


                                        <?php
                                        $mapped_options = \yii\helpers\ArrayHelper::map($product['option'], 'product_option_id', 'option_value_id');
                                        foreach ($product_object->productOptions as $productOption) { ?>
                                            <div class="size_select">
                                                <span><?= $productOption->option->name;?></span>
                                                <a href="#"><em><?= \common\models\option\OptionValue::findOne( $mapped_options[ $productOption->id ] )->name; ?></em></a>
                                                <ul>
                                                    <?php foreach ($productOption->values as $value) { ?>
                                                        <li>
                                                            <label>
                                                                <input
                                                                    type="radio"
                                                                    <?php if ($mapped_options[$value->product_option_id] == $value->option_value_id) { echo 'checked'; } ?>
                                                                    name="AddToCartForm[option][<?=$productOption->id;?>]"
                                                                    value="<?=$value->id;?>">
                                                                <a href="#"><?=$value->optionValue->name;?></a>
                                                            </label>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>

                                        <div class="count_select">
                                            <span><?= Yii::t('app', 'Quantity'); ?></span>
                                            <input type="text" name="AddToCartForm[quantity]" value="<?= $product['quantity']; ?>">
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p style="margin-top: 20px;"><?= Yii::t('app', 'Basket is empty'); ?></p>
            <?php } ?>
        </div>

        <div class="delivery_info">
            <h3><?= Yii::t('app', 'Free shipping'); ?></h3>
            <p><?= Yii::t('app', 'Delivery to all regions of the country is possible'); ?></p>
            <div class="link"><a href="<?= Info::findOne(5)->url; ?>"><?= Yii::t('app', 'More info'); ?></a></div>
        </div>
        <div class="return_info">
            <h3><?= Yii::t('app', 'Easy refund'); ?></h3>
            <p><?= Yii::t('app', 'Ability to refund the product within 14 days'); ?></p>
            <div class="link"><a href="<?= Info::findOne(6)->url; ?>"><?= Yii::t('app', 'More info'); ?></a></div>
        </div>
    </div>

    <?php if ($cart->hasProducts()) { ?>
    <div class="right_side">
        <div class="basket_total">
            <h3><?= Yii::t('app', 'Checkout'); ?></h3>
            <div class="prices">
                <dl>
                    <dt><?= Yii::t('app', 'Total'); ?></dt>
                    <dd>
                        <?= $currency->convertAndFormat($cart->subTotal, $product_object->currency); ?>
                    </dd>
                </dl>
            </div>
            <div class="submit">
                <a href="<?= Url::to(['checkout/index']);?>"><?= Yii::t('app', 'Checkout'); ?></a>
            </div>
            <div class="payment_ways">
                <p><?= Yii::t('app', 'We accept'); ?>:</p>
                <div class="credit_cards">
                    <a href="#"><img src="/img/card_paypal.svg" alt="PayPal"></a>
                    <a href="#"><img src="/img/card_bolcard.svg" alt="Bolkart"></a>
                    <a href="#"><img src="/img/card_albali.svg" alt="Albalı"></a>
                    <a href="#"><img src="/img/card_master.svg" alt="Master Card"></a>
                    <a href="#"><img src="/img/card_visa.svg" alt="Visa"></a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>