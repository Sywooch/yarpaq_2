<?php
use common\models\Product;
use yii\helpers\Url;
use common\models\info\Info;
use common\models\product\Discount;

$currency = Yii::$app->currency;

?>
<div class="current_product" itemscope itemtype="http://schema.org/Product">
    <?php if ($product->manufacturer) { ?>
        <meta itemprop="brand" content="<?= $product->manufacturer->title; ?>" />
    <?php } ?>

    <div class="priduct_gallery">

        <div id="mobile-gallery">
            <?php $i=0; foreach ($product->gallery as $image) { $i++; ?>
                <div>
                    <img src="<?= $image->standard->url; ?>" alt="<?= $product->title ?>">
                </div>
            <?php } ?>
        </div>

        <div id="desktop-gallery">
            <div class="image">
                <div>
                    <?php if (count($product->gallery)) { ?>
                        <img itemprop="image" class="_xzoom" src="<?= $product->gallery[0]->standard->url; ?>" width="370" alt="" xoriginal="<?= $product->gallery[0]->url; ?>">
                    <?php } ?>

                </div>
            </div>
            <div class="thumbnails">
                <div class="swipe">
                    <div class="xzoom-thumbs">

                        <?php $i=0; foreach ($product->gallery as $image) { $i++; ?>
                            <a href="<?= $image->url; ?>" class="thumb">
                                <img class="xzoom-gallery" width="64"
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
                <h3 itemprop="name"><?= $product->title; ?></h3>
                <div class="first_info">
                    <div class="rating">
                        <span class="star_<?= $product->rating; ?>"></span>
                    </div>
                    <p><span><?= Yii::t('app', 'Views count'); ?>: <strong><?= $product->viewed; ?></strong></span> | <span><?= Yii::t('app', 'Product code'); ?>: <strong><?= $product->id; ?></strong></span></p>
                </div>
            </header>
            <div class="product_first_info" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <div class="left_info">
                    <div class="price">

                        <span><?= Yii::t('app', 'Price'); ?>:</span>

                        <!-- Price -->
                        <meta itemprop="priceCurrency" content="<?= $product->currency->code; ?>" />
                        <meta itemprop="price" content="<?= $product->realPrice; ?>" />

                        <b><?= $currency->convertAndFormat($product->realPrice, $product->currency); ?></b>

                        <br><br>
                        <?php if ($product->hasDiscount() && $product->discount->period == Discount::PERIOD_RANGE) { ?>
                            (<time itemprop="priceValidUntil" datetime="<?= (new \DateTime($product->discount->end_date))->format('Y-m-d\TH:i:sO'); ?>">
                                <?= (new \DateTime($product->discount->end_date))->format('d M Y'); ?>
                            </time>)
                        <?php } ?>
                    </div>

                    <ul>
                        <!-- Condition -->
                        <li>
                            <?= Yii::t('app', 'Condition'); ?>:

                            <?php if ($product->condition_id == Product::CONDITION_NEW) { ?>
                            <b itemprop="itemCondition" content="http://schema.org/NewCondition">
                                <?php } else if ($product->condition_id == Product::CONDITION_USED) { ?>
                                <b itemprop="itemCondition" content="http://schema.org/UsedCondition">
                                    <?php } ?>

                                    <?= Yii::t('app', $product->condition);?>

                                </b>
                        </li>


                        <!-- Brand -->
                        <?php if ($product->manufacturer) { ?>
                            <li><?= Yii::t('app', 'Brand'); ?>:  <b><?= $product->manufacturer->title; ?></b></li>
                        <?php } ?>


                        <!-- Availability -->
                        <li>
                            <?= Yii::t('app', 'Availability'); ?>:
                            <?php if ($product->stock_status_id == Product::AVAILABILITY_IN_STOCK) { ?>
                            <b itemprop="availability" content="http://schema.org/InStock">
                                <?php } else if ($product->stock_status_id == Product::AVAILABILITY_PRE_ORDER) { ?>
                                <b itemprop="availability" content="http://schema.org/PreOrder">
                                    <?php } else { ?>
                                    <b itemprop="availability" content="http://schema.org/OutOfStock">
                                        <?php } ?>

                                        <?= Yii::t('app', $product->stockStatus->name);?>
                                    </b>
                        </li>

                    </ul>

                    <!-- Url -->
                    <meta itemprop="url" content="<?= Url::to($product->url, true); ?>">
                </div>

            </div>

            <?php if ($product->hasStock()) { ?>
                <div class="product_second_info">
                    <form action="/cart/add" method="post">

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