<?php
use common\models\Product;
use common\models\info\Info;
use common\models\product\Discount;
use common\models\Language;

$currency = Yii::$app->currency;

?>
<div class="current_product">
    <div class="priduct_gallery">

        <div id="desktop-gallery">
            <div class="image">
                <div>
                    <?php if (count($product->gallery)) { ?>
                        <img class="_xzoom" src="<?= $product->gallery[0]->standard->url; ?>" width="370" alt="" xoriginal="<?= $product->gallery[0]->url; ?>">
                    <?php } ?>

                </div>
            </div>
            <div class="thumbnails">
                <div class="swipe">
                    <div class="xzoom-thumbs">

                        <?php $i=0; foreach ($product->gallery as $image) { $i++; ?>
                            <a href="<?= $image->url; ?>" class="thumb">
                                <img class="xzoom-gallery" width="64" height="64"
                                     src="<?= $image->preview->url; ?>"
                                     xpreview="<?= $image->standard->url; ?>">
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <?php if (count($product->gallery) > 5) { ?>
                    <div class="arrows">
                        <a href="#" class="prev unactive"></a>
                        <a href="#" class="next"></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="right_side">
        <div class="product_first">
            <header>
                <h1><?= $product->title; ?></h1>
                <div class="first_info">
                    <div class="rating">
                        <span class="star_<?= $product->rating; ?>"></span>
                    </div>
                    <p><span><?= Yii::t('app', 'Views count'); ?>: <strong><?= $product->viewed; ?></strong></span> | <span><?= Yii::t('app', 'Product code'); ?>: <strong><?= $product->id; ?></strong></span></p>
                </div>
            </header>
            <div class="product_first_info">
                <div class="left_info">
                    <div class="price">

                        <span><?= Yii::t('app', 'Price'); ?>:</span>

                        <!-- Price -->
                        <?php if ($product->hasDiscount()) { ?>
                            <b style="text-decoration: line-through; font-size: 26px;"><?= $currency->convertAndFormat($product->oldPrice, $product->currency); ?></b>

                            <b style="color: red; margin-left: 20px;"><?= $currency->convertAndFormat($product->realPrice, $product->currency); ?></b>

                            <?php if ($product->discount->period == Discount::PERIOD_RANGE) { ?>
                                <br><br>

                                <?= Yii::t('app', 'Available till'); ?>: <time itemprop="priceValidUntil" datetime="<?= (new \DateTime($product->discount->end_date))->format('Y-m-d\TH:i:sO'); ?>">
                                    <?= (new \DateTime($product->discount->end_date))->format('d.m.Y'); ?>
                                </time>
                            <?php } ?>
                        <?php } else { ?>

                            <b><?= $currency->convertAndFormat($product->realPrice, $product->currency); ?></b>

                        <?php } ?>
                    </div>

                    <ul>
                        <!-- Condition -->
                        <li>
                            <?= Yii::t('app', 'Condition'); ?>:
                            <b><?= Yii::t('app', $product->condition);?></b>
                        </li>


                        <!-- Brand -->
                        <?php if ($product->manufacturer) { ?>
                            <li><?= Yii::t('app', 'Brand'); ?>:  <b><?= $product->manufacturer->title; ?></b></li>
                        <?php } ?>


                        <!-- Availability -->
                        <li>
                            <?= Yii::t('app', 'Availability'); ?>:
                            <b><?= Yii::t('app', $product->stockStatus->name);?></b>
                        </li>

                    </ul>
                </div>

            </div>

            <?php if ($product->hasStock()) { ?>
                <div class="product_second_info">
                    <form action="<?= Language::getCurrent()->urlPrefix; ?>/cart/add" method="post">

                        <input class="form-token" type="hidden"
                               name="<?=Yii::$app->request->csrfParam?>"
                               value="<?=Yii::$app->request->csrfToken?>"/>

                        <input type="hidden" name="AddToCartForm[productId]" value="<?=$product->id;?>">

                        <?php foreach ($product->productOptions as $productOption) { ?>
                            <div class="product_size">
                                <p><?= $productOption->option->name;?>:</p>
                                <ul>
                                    <?php $i=0; foreach ($productOption->values as $value) { $i++; ?>
                                        <li>
                                            <label>
                                                <input type="radio" <?php if ($i===1) { echo 'checked'; } ?> name="AddToCartForm[option][<?=$productOption->id;?>]" value="<?=$value->id;?>">

                                                <?php if ($value->optionValue->image) { ?>
                                                    <span class="icon" style="background-image: url('<?= $value->optionValue->url; ?>');"></span>
                                                <?php } else { ?>
                                                    <span><?=$value->optionValue->name;?></span>
                                                <?php } ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>

                        <div class="product_buy_last">
                            <div class="buttons">
                                <button type="submit" class="add"><?= Yii::t('app', 'Add to basket'); ?></button>
                            </div>
                            <div class="delivery">
                                <p><?= Yii::t('app', 'Shipping'); ?>:</p>
                                <span><?= Yii::t('app', '1-3 days'); ?> <a href="<?= Info::findOne(5)->url; ?>"><?= Yii::t('app', 'More info'); ?></a></span>
                            </div>
                        </div>

                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>