<?php
use yii\helpers\Url;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\Zone;
use common\models\Country;

$currency = Yii::$app->currency;
?>

<div class="basket_wrapper no_toppadding">
    <h2><?= Yii::t('app', 'Checkout'); ?></h2>
    <div class="main_side">
        <?php if ($user) { ?>
        <div class="shipping_address_edit">
            <h3><?= Yii::t('app', 'Shipping address'); ?></h3>
            <div class="list">
                <ul>
                    <li>
                        <label>
                            <span>Orkhan Haciev <br>
                            General Sixlinski 42, mənsiz 113<br>
                            Baku<br>
                            Azerbaijan<br>
                            AZ1129<br>
                            Azerbaijan<br>
                            +944558555644</span>
                            <input type="radio" name="adress_name">
                            <em></em>
                            <strong>Bu sizin hal-hazırki çatdırılma ünvanınızdır</strong>
                            <a href="#">ünvana düzəlİş et</a>
                        </label>
                    </li>
                    <li>
                        <label>
                            <span>Orkhan Haciev <br>
                            General Sixlinski 42, mənsiz 113<br>
                            Baku<br>
                            Azerbaijan<br>
                            AZ1129<br>
                            Azerbaijan<br>
                            +944558555644</span>
                            <input type="radio" name="adress_name">
                            <em></em>
                            <strong>Bu sizin hal-hazırki çatdırılma ünvanınızdır</strong>
                            <a href="#">ünvana düzəlİş et</a>
                        </label>
                    </li>
                </ul>
            </div>
            <footer>
                <div class="add_new"><a href="#">Yenİ ünvan əlavə et</a></div>
                <div class="cancel"><a href="#">ləğv etmək</a></div>
            </footer>
        </div>
        <?php } else { ?>
        <div class="address_form">
            <h3><?= Yii::t('app', 'Shipping information'); ?></h3>

            <ul>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Name'); ?>:</span>
                        <em>*</em>
                    </div>
                    <input type="text" name="shipping_firstname" value="<?= $shipping_info['firstname']; ?>">
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Surname'); ?> :</span>
                        <em>*</em>
                    </div>
                    <input type="text" name="shipping_lastname" value="<?= $shipping_info['lastname']; ?>">
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Mobile phone'); ?> </span>
                        <em>*</em>
                    </div>
                    <input type="text" name="phone1" value="<?= $user_info['phone1']; ?>">
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Email'); ?> :</span>
                    </div>
                    <input type="text" name="email" value="<?= $user_info['email']; ?>">
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Street'); ?> :</span>
                        <em>*</em>
                    </div>
                    <input type="text" name="shipping_address" value="<?= $shipping_info['address']; ?>">
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'City'); ?> :</span>
                        <em>*</em>
                    </div>
                    <input type="text" name="shipping_city" value="<?= $shipping_info['city']; ?>">
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Postal code'); ?> :</span>
                        <em>*</em>
                    </div>
                    <input type="text" value="<?= $shipping_info['postal_code']; ?>">
                    <strong>Bu xananın doldurulması vacibdir</strong>
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'Country'); ?> :</span>
                        <em>*</em>
                    </div>
                    <select name="shipping_zone_id" id="country_select">
                        <?php
                        $countries = Country::find()->all();

                        foreach ($countries as $country) { ?>
                            <option <?= $country->id == 15 ? 'selected' : ''; ?> value="<?= $country->id; ?>"><?= $country->name; ?></option>
                        <?php } ?>
                    </select>
                </li>
                <li>
                    <div>
                        <span><?= Yii::t('app', 'State'); ?> :</span>
                        <em>*</em>
                    </div>

                    <?php
                    $zones = Zone::find()->all();

                    foreach ($countries as $country) {
                        ?>
                        <select name="shipping_zone_id" class="zones_select" id="zones_<?= $country->id; ?>" style="display: none;">
                            <?php

                            foreach ($zones as $zone) {
                                if ($zone->country_id != $country->id) {
                                    continue;
                                }
                                ?>
                                <option value="<?= $zone->id; ?>"><?= $zone->name; ?></option>
                            <?php } ?>
                        </select>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
        <?php } ?>

        <div class="delivery_methods">
            <h3><?= Yii::t('app', 'Shipping method'); ?></h3>
            <ul>
                <li>
                    <p>Kuryer vasitəsi ilə</p>
                    <label>
                        <span>Bakıdaxili çatdırılma pulsuzdur. Bakıkənarı çatdırılma isə 2 AZN-dir və 3 iş günü ərzində həyata keçirilir.</span>
                        <input type="radio" name="delivery_type">
                        <em></em>
                    </label>
                </li>
                <li>
                    <p>Poçt vasitəsi ilə</p>
                    <label>
                        <span>Regionlara çatdırılma 3 AZN-dir, Azərpoçt vasitəsilə maksimum 5-6 iş günü ərzində çatdırılır.</span>
                        <input type="radio" name="delivery_type">
                        <em></em>
                    </label>
                </li>
            </ul>
        </div>
        <div class="payment_methods">
            <header>
                <h3><?= Yii::t('app', 'Payment method'); ?></h3>
            </header>
            <div class="methods_list">
                <ul>
                    <li>
                        <label>
                            <div class="image"><img src="/img/paypal_icon.png" alt=""></div>
                            <span>PayPal</span>
                            <input type="radio" name="payment_type">
                            <em></em>
                        </label>
                        <div>
                            <a href="#">1 AY</a>
                            <a href="#" class="active">3 AY</a>
                            <a href="#">6 AY</a>
                        </div>
                    </li>
                    <li>
                        <label>
                            <div class="image"><img src="/img/visa_icon.svg" alt=""></div>
                            <span>Visa Electron</span>
                            <input type="radio" name="payment_type">
                            <em></em>
                        </label>
                        <div>
                            <a href="#">1 AY</a>
                            <a href="#" class="active">3 AY</a>
                            <a href="#">6 AY</a>
                        </div>
                    </li>
                    <li>
                        <label>
                            <div class="image"><img src="/img/mastercaed_icon.svg" alt=""></div>
                            <span>Master Card</span>
                            <input type="radio" name="payment_type">
                            <em></em>
                        </label>
                        <div>
                            <a href="#">1 AY</a>
                            <a href="#" class="active">3 AY</a>
                            <a href="#">6 AY</a>
                        </div>
                    </li>
                    <li>
                        <label>
                            <div class="image"><img src="/img/albali_icon.png" alt=""></div>
                            <span>Albalı Kart</span>
                            <input type="radio" name="payment_type">
                            <em></em>
                        </label>
                        <div>
                            <a href="#">1 AY</a>
                            <a href="#" class="active">3 AY</a>
                            <a href="#">6 AY</a>
                        </div>
                    </li>
                    <li>
                        <label>
                            <div class="image"><img src="/img/bolcard_icon.png" alt=""></div>
                            <span>Bolkart</span>
                            <input type="radio" name="payment_type">
                            <em></em>
                        </label>
                        <div>
                            <a href="#">1 AY</a>
                            <a href="#" class="active">3 AY</a>
                            <a href="#">6 AY</a>
                        </div>
                    </li>
                    <li>
                        <label>
                            <div class="image"><img src="/img/cash_icon.svg" alt=""></div>
                            <span>Nəğd ödəmə</span>
                            <input type="radio" name="payment_type">
                            <em></em>
                        </label>
                        <div>
                            <a href="#">1 AY</a>
                            <a href="#" class="active">3 AY</a>
                            <a href="#">6 AY</a>
                        </div>
                    </li>
                </ul>
            </div>
            <footer>
                <p><?= Yii::t('app', 'We accept'); ?>:</p>
                <img src="/img/all_cards.png" alt="">
            </footer>
        </div>
        <div class="payment_checkout">
            <div class="button"><a href="#">CHECKOUT</a></div>
            <p>Siz sifariş verərək <a href="#">Şərtlər və Qaydalar</a>, <a href="#">Gizlilik və Geri qaytarma</a> şərtləri ilə razılaşmış olursunuz.</p>
        </div>
    </div>

    <!-- Cart -->
    <div class="right_side">
        <div class="right_basket">
            <header>
                <h3><?= $cart->countProducts(); ?> <?= Yii::t('app', 'product'); ?></h3>
                <a href="<?= Url::to(['cart/index']); ?>"><?= Yii::t('app', 'Edit'); ?></a>
            </header>
            <div class="right_basket_list">

                <?php foreach ($cart->products as $product) {
                    $product_object = \common\models\Product::findOne($product['product_id']);
                    ?>
                <article>
                    <div class="image">
                        <a href="<?= $product_object->url; ?>">
                            <img src="<?= $product_object->preview; ?>" alt="<?= $product_object->title; ?>">
                        </a>
                    </div>
                    <div class="inner">
                        <div class="price">
                            <?= $currency->convertAndFormat($product_object->price, $product_object->currency); ?>
                        </div>
                        <p><?= $product_object->title; ?></p>


                        <?php
                        if (count($product['option'])) {
                            foreach ($product['option'] as $option) {
                                $value = ProductOptionValue::findOne($option['product_option_value_id']);
                                $product_option = ProductOption::findOne($option['product_option_id']); ?>

                                <div class="size">
                                    <span><?= $product_option->option->name;?></span>

                                    <?php if ($value->optionValue->image) { ?>
                                        <em class="icon" style="background-image: url('/uploads/options/<?= $productOption->option->id; ?>/<?= $value->optionValue->image; ?>');"></em>
                                    <?php } else { ?>
                                        <em><?=$value->optionValue->name;?></em>
                                    <?php } ?>
                                </div>

                            <?php
                            }
                        }
                        ?>


                        <div class="count">
                            <?= Yii::t('app', 'Quantity'); ?> <strong><?= $product['quantity']; ?></strong>
                        </div>
                    </div>
                </article>
                <?php } ?>
            </div>
            <div class="totals">
                <dl>
                    <dt><?= Yii::t('app', 'Total'); ?></dt>
                    <dd>
                        <?= $currency->format($cart->total); ?>
                    </dd>
                    <dt><?= Yii::t('app', 'Shipping'); ?></dt>
                    <dd><?= Yii::t('app', 'Free'); ?></dd>
                </dl>
                <dl>
                    <dt><?= Yii::t('app', 'Total'); ?></dt>
                    <dd>
                        <?= $currency->format($cart->total); ?>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="right_basket_info">
            <p>Qaytarış yerində hər bir məhsula görə 2 AZN təşkil edir. Məhsul təsvirə yaxud şəkillərə uyğun gəlmədikdə ödənişsiz qaytarla bilər (<a href="#">ətraflı</a>)</p>
        </div>
    </div>
</div>