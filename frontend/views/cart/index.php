<?php

use common\models\Product;

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


                                        <?php foreach ($product_object->productOptions as $productOption) { ?>
                                            <div class="size_select">
                                                <span><?= $productOption->option->name;?></span>
                                                <a href="#"><em>S</em></a>
                                                <ul>
                                                    <?php foreach ($productOption->values as $value) { ?>
                                                        <li>
                                                            <label>
                                                                <input type="radio" name="AddToCartForm[option][<?=$productOption->id;?>]" value="<?=$value->id;?>">
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
                <footer>
                    <div class="price">
                        <?= $currency->convertAndFormat($cart->subTotal, $product_object->currency); ?>
                    </div>
                    <p><?= Yii::t('app', 'Subtotal'); ?></p>
                </footer>
            <?php } else { ?>
                <p style="margin-top: 20px;"><?= Yii::t('app', 'Basket is empty'); ?></p>
            <?php } ?>
        </div>

        <div class="delivery_info">
            <h3><?= Yii::t('app', 'Free shipping'); ?></h3>
            <p><?= Yii::t('app', 'Delivery to all regions of the country is possible'); ?></p>
            <div class="link"><a href="#"><?= Yii::t('app', 'More info'); ?></a></div>
        </div>
        <div class="return_info">
            <h3><?= Yii::t('app', 'Easy refund'); ?></h3>
            <p><?= Yii::t('app', 'Ability to refund the product within 14 days'); ?></p>
            <div class="link"><a href="#"><?= Yii::t('app', 'More info'); ?></a></div>
        </div>
    </div>

    <?php if ($cart->hasProducts()) { ?>
    <div class="right_side">
        <div class="basket_total">
            <h3><?= Yii::t('app', 'Total'); ?></h3>
            <div class="prices">
                <dl>
                    <dt>Toplam</dt>
                    <dd>48<span>m</span></dd>
                    <dt>Yekun məbləğ</dt>
                    <dd>48<span>m</span></dd>
                </dl>
            </div>
            <div class="delivery_select">
                <select name="" id="">
                    <option value="0">Çatdırılma üsulu</option>
                    <option value="0">Çatdırılma 2</option>
                </select>
            </div>
            <div class="submit"><a href="#">CHECKOUT</a></div>
            <div class="payment_ways">
                <p>QƏBUL EDİRİK:</p>
                <div class="credit_cards">
                    <a href="#"><img src="/img/card_paypal.svg" alt="PayPal"></a>
                    <a href="#"><img src="/img/card_bolcard.svg" alt="Bolkart"></a>
                    <a href="#"><img src="/img/card_albali.svg" alt="Albalı"></a>
                    <a href="#"><img src="/img/card_master.svg" alt=""></a>
                    <a href="#"><img src="/img/card_visa.svg" alt=""></a>
                </div>
            </div>
        </div>
        <div class="basket_info">
            <ul>
                <li>Kuyer ilə (Bakidaxili pulsuz)</li>
                <li>Poçt vasitəsi ilə</li>
            </ul>
        </div>
    </div>
    <?php } ?>
</div>