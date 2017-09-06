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
        <form action="<?= Url::toRoute(['checkout/confirm']); ?>" method="post" id="checkout-form">

            <input class="form-token" type="hidden"
                   name="<?=Yii::$app->request->csrfParam?>"
                   value="<?=Yii::$app->request->csrfToken?>">

            <div class="address_form">
                <h3><?= Yii::t('app', 'Shipping information'); ?></h3>

                <ul>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'Name'); ?>:</span>
                            <em>*</em>
                        </div>
                        <input type="text" required name="shipping_firstname" value="<?= $shipping_info['firstname']; ?>">
                    </li>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'Surname'); ?> :</span>
                            <em>*</em>
                        </div>
                        <input type="text" required name="shipping_lastname" value="<?= $shipping_info['lastname']; ?>">
                    </li>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'Mobile phone'); ?> </span>
                            <em>*</em>
                        </div>
                        <input type="text" required name="phone1" value="<?= $user_info['phone1']; ?>">
                    </li>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'Email'); ?> :</span>
                        </div>
                        <input type="text" required name="email" value="<?= $user_info['email']; ?>">
                    </li>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'Address'); ?> :</span>
                            <em>*</em>
                        </div>
                        <input type="text" required name="shipping_address" value="<?= $shipping_info['address']; ?>">
                    </li>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'City'); ?> :</span>
                            <em>*</em>
                        </div>
                        <input type="text" required name="shipping_city" value="<?= $shipping_info['city']; ?>">
                    </li>
                    <li>
                        <div>
                            <span><?= Yii::t('app', 'Postal Code'); ?> :</span>
                            <em>*</em>
                        </div>
                        <input type="text" name="shipping_postcode" required value="<?= $shipping_info['postcode']; ?>">
                    </li>
                    <li>
                        <?php $default_country_id = $shipping_info['country_id'] ? $shipping_info['country_id'] : 15 ?>
                        <div>
                            <span><?= Yii::t('app', 'Country'); ?> :</span>
                            <em>*</em>
                        </div>
                        <select name="shipping_country_id" id="country_select">
                            <?php
                            $countries = Country::find()->all();

                            foreach ($countries as $country) { ?>
                                <option <?= $country->id == $default_country_id ? 'selected' : ''; ?> value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <li>
                        <?php $default_zone_id = $shipping_info['zone_id'] ? $shipping_info['zone_id'] : 216 ?>
                        <div>
                            <span><?= Yii::t('app', 'State'); ?> :</span>
                            <em>*</em>
                        </div>

                        <select name="shipping_zone_id" class="zones_select" id="zone_select" data-default="<?= $default_zone_id; ?>">

                        </select>
                    </li>
                </ul>
            </div>

            <div class="delivery_methods">
                <h3><?= Yii::t('app', 'Shipping method'); ?></h3>
                <ul>
                    <li class="shipping_method_block" id="elpost_shipping_method_block">
                        <p><?= Yii::t('app', 'By courier'); ?></p>
                        <label>
                            <span><?= Yii::t('app', 'Free delivery is available inside Baku city. Delivery to Baku vicinities costs 2 AZN, it is carried out during 3 days.'); ?></span>
                            <input type="radio" name="shipping_method" value="1" id="elpost_method">
                            <em></em>
                        </label>
                    </li>
                    <li class="shipping_method_block" id="azerpoct_shipping_method_block">
                        <p><?= Yii::t('app', 'By post'); ?></p>
                        <label>
                            <span><?= Yii::t('app', 'Delivery to regions costs 3 AZN, it is carried out maximum during 5-6 days through Azərpoçt'); ?></span>
                            <input type="radio" name="shipping_method" value="2" id="azerpoct_method">
                            <em></em>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="payment_methods">
                <header>
                    <span class="error_text"><?= Yii::t('app', 'Choose payment type'); ?></span>
                    <h3><?= Yii::t('app', 'Payment method'); ?></h3>
                </header>
                <div class="methods_list">
                    <ul>
                        <li class="payment_method_row">
                            <label>
                                <div class="image"><img src="/img/paypal_icon.png" alt=""></div>
                                <span>PayPal</span>
                                <input type="radio" name="payment_method" value="5">
                                <em></em>
                            </label>
                        </li>
                        <li class="payment_method_row">
                            <label>
                                <div class="image"><img src="/img/visa_icon.svg" alt=""></div>
                                <span>Visa</span>
                                <input type="radio" name="payment_method" value="3.v">
                                <em></em>
                            </label>
                        </li>
                        <li class="payment_method_row">
                            <label>
                                <div class="image"><img src="/img/mastercaed_icon.svg" alt=""></div>
                                <span>Master Card</span>
                                <input type="radio" name="payment_method" value="3.m">
                                <em></em>
                            </label>
                        </li>
                        <li class="payment_method_row">
                            <label>
                                <div class="image"><img src="/img/albali_icon.png" alt=""></div>
                                <span>Albalı</span>
                                <input type="radio" name="payment_method" value="2.3" id="albali_method">
                                <em></em>
                            </label>
                            <div>
                                <a href="#" data-taksit="1" class="albali_taksit">1 <?= Yii::t('app', 'Ay'); ?></a>
                                <a href="#" data-taksit="3" class="albali_taksit active">3 <?= Yii::t('app', 'Ay'); ?></a>
                                <a href="#" data-taksit="6" class="albali_taksit">6 <?= Yii::t('app', 'Ay'); ?></a>
                            </div>
                        </li>
                        <li class="payment_method_row">
                            <label>
                                <div class="image"><img src="/img/bolcard_icon.png" alt=""></div>
                                <span>Bolkart</span>
                                <input type="radio" name="payment_method" value="1.3" id="bolkart_method">
                                <em></em>
                            </label>
                            <div>
                                <a href="#" data-taksit="1" class="bolkart_taksit">1 <?= Yii::t('app', 'Ay'); ?></a>
                                <a href="#" data-taksit="3" class="bolkart_taksit active">3 <?= Yii::t('app', 'Ay'); ?></a>
                                <a href="#" data-taksit="6" class="bolkart_taksit">6 <?= Yii::t('app', 'Ay'); ?></a>
                            </div>
                        </li>
                        <li class="payment_method_row" id="payment_method_cod">
                            <label>
                                <div class="image"><img src="/img/cash_icon.svg" alt=""></div>
                                <span><?= Yii::t('app', 'Cash'); ?></span>
                                <input type="radio" name="payment_method" value="6">
                                <em></em>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="payment_checkout">
                <div class="button">
                    <a href="#" id="checkout-submit"><?= Yii::t('app', 'Checkout'); ?></a>
                </div>
                <p>
                    <?php
                    $terms_conditions = \common\models\info\Info::findOne(9);
                    $privacy_policy = \common\models\info\Info::findOne(8);

                    echo Yii::t('app', 'With making an order you agree with {Terms and Conditions}, with conditions of {Confidentiality and Return}', [
                        'Terms and Conditions'          => '<a target="_blank" href="'.$terms_conditions->url.'">'.$terms_conditions->title.'</a>',
                        'Confidentiality and Return'    => '<a target="_blank" href="'.$privacy_policy->url.'">'.$privacy_policy->title.'</a>'
                    ]); ?>
                </p>
            </div>
        </form>
    </div>

    <!-- Cart -->
    <div class="right_side">
        <div class="right_basket">
            <header>
                <h3><?= $cart->countProducts(); ?> <?= Yii::t('app', 'Product'); ?></h3>
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
            <p>
                <?= Yii::t('app', 'A product can be returned at place for 2 azn. In case of not looking as in description or photos, it can be returned for free.'); ?>
                <?php $return_policy = \common\models\info\Info::findOne(6); ?>
                (<a href="<?= $return_policy->url; ?>"><?= Yii::t('app', 'More info'); ?></a>)
            </p>
        </div>
    </div>
</div>