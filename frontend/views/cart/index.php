<?php

use common\models\Product;
use common\models\info\Info;
use yii\helpers\Url;
use common\models\option\OptionValue;

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

                    <input class="form-token" type="hidden"
                           name="<?=Yii::$app->request->csrfParam?>"
                           value="<?=Yii::$app->request->csrfToken?>">

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

                                    <?php
                                    $mapped_options = \yii\helpers\ArrayHelper::map($product['option'], 'product_option_id', 'option_value_id');
                                    foreach ($product_object->productOptions as $productOption) {
                                        if (!isset($mapped_options[ $productOption->id ])) continue;
                                        ?>
                                        <div class="size_select">
                                            <span><?= $productOption->option->name;?></span>
                                            <a href="javascript:void(0)">
                                                <?php
                                                $optionValue = OptionValue::findOne( $mapped_options[ $productOption->id ] );
                                                ?>
                                                <?php if ($optionValue->image) { ?>
                                                    <span class="icon" style="background-image: url('<?= $optionValue->url; ?>');"></span>
                                                <?php } else { ?>
                                                    <span><?=$optionValue->name;?></span>
                                                <?php } ?>
                                            </a>

                                            <!--<ul>
                                                <?php foreach ($productOption->values as $value) { ?>
                                                    <li>
                                                        <label>
                                                            <a
                                                                href="#"
                                                                <?php if ($mapped_options[$value->product_option_id] == $value->option_value_id) { echo 'class="active"'; } ?>
                                                                data-product-option-id="<?=$productOption->id;?>"
                                                                data-value="<?=$value->id;?>"><?=$value->optionValue->name;?></a>
                                                        </label>
                                                    </li>
                                                <?php } ?>
                                            </ul> -->
                                        </div>
                                    <?php } ?>

                                    <div class="count_select">
                                        <span><?= Yii::t('app', 'Quantity'); ?></span>
                                        <input type="text" name="AddToCartForm[quantity]" value="<?= $product['quantity']; ?>" data-product-id="<?=$product_object->id;?>">
                                    </div>

                                </div>
                            </div>
                            <a href="javascript:void(0)" class="close" data-product-id="<?=$product_object->id;?>"></a>
                        </article>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p style="margin-top: 20px;"><?= Yii::t('app', 'Basket is empty'); ?></p>
            <?php } ?>
        </div>

        <div class="delivery_info">
            <h3><?= Yii::t('app', 'Free shipping'); ?></h3>
            <p><?= Yii::t('app', 'Delivery to all regions of the country is available'); ?></p>
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
                    <dd id="cart-total">
                        <?= $currency->format($cart->subTotal, $product_object->currency); ?>
                    </dd>
                </dl>
            </div>
            <div class="submit">
                <a href="<?= Url::to(['checkout/index']);?>"><?= Yii::t('app', 'Checkout'); ?></a>
            </div>
            <div class="payment_ways">
                <p><?= Yii::t('app', 'We accept'); ?>:</p>
                <div class="credit_cards">
                    <span><img src="/img/card_paypal.svg" alt="PayPal"></span>
                    <span><img src="/img/card_bolcard.svg" alt="Bolkart"></span>
                    <span><img src="/img/card_albali.svg" alt="Albalı"></span>
                    <span><img src="/img/card_master.svg" alt="Master Card"></span>
                    <span><img src="/img/card_visa.svg" alt="Visa"></span>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>