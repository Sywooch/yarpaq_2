<?php

use frontend\components\taksit\Albali;
use frontend\components\taksit\Bolkart;
use common\models\info\Info;

$currency = Yii::$app->currency;

?>
<div class="product_block">
    <header>

        <!-- Breadcrumbs -->
        <?= $this->render('@app/views/blocks/breadcrumb', [
            'parents' => $product->category[0]->getParents(true)->all(),
            'currentPageTitle' => $product->title
        ]); ?>
        <!-- Breadcrumbs END -->

    </header>
    <div class="current_product">
        <div class="priduct_gallery">
            <div class="image"><div><img src="<?= $product->gallery[0]->url; ?>" alt=""></div></div>
            <div class="thumbnails">
                <ul>
                    <?php $i=0; foreach ($product->gallery as $image) { $i++; ?>
                    <li><a href="<?= $image->url; ?>" <?= $i===1 ? 'class="active"' : ''; ?>><img src="<?= $image->url; ?>" alt=""></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="right_side">
            <div class="product_first">
                <header>
                    <h3><?= $product->title; ?></h3>
                    <div class="first_info">
                        <div class="rating">
                            <span class="star_<?= $product->rating; ?>"></span>
                        </div>
                        <p><span><?= Yii::t('app', 'Views count'); ?>: <strong><?= $product->viewed; ?></strong></span> | <span><?= Yii::t('app', 'Product id'); ?>: <strong><?= $product->id; ?></strong></span> | <span><?= Yii::t('app', 'Quantity'); ?>: <strong><?= $product->quantity; ?></strong></span></p>
                    </div>
                    <div class="second_info">
                        <div class="wrap_store">
                            <?= Yii::t('app', 'Seller'); ?>: <b><?= $product->seller->fullname; ?></b>
                            (<a href="<?= \yii\helpers\Url::to(['seller-products/index', 'id' => $product->seller->id]); ?>"><?= Yii::t('app', 'See other products'); ?></a>)
                        </div>
                    </div>
                </header>
                <div class="product_first_info">
                    <div class="left_info">
                        <div class="price">
                            <span><?= Yii::t('app', 'Price'); ?>:</span>
                            <b>
                                <?= $currency->convertAndFormat($product->price, $product->currency); ?>
                            </b>
                        </div>
                        <ul>
                            <li><?= Yii::t('app', 'Condition'); ?>:  <b><?= Yii::t('app', $product->condition);?></b></li>

                            <?php if ($product->manufacturer) { ?>
                            <li><?= Yii::t('app', 'Brand'); ?>:  <b><?= $product->manufacturer->name; ?></b></li>
                            <?php } ?>

                        </ul>
                    </div>
                    <div class="cards_dicsount">

                        <?php $albali = new Albali($product->price); ?>
                        <div>
                            <h4>Albalı</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <?php foreach ($albali->getMonths() as $month) { ?>
                                        <td><?= $month; ?> <?= Yii::t('app', 'AY'); ?></td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= Yii::t('app', 'Aylıq ödəniş'); ?></td>
                                        <?php foreach ($albali->getMonths() as $month) { ?>
                                            <td><?= $albali->getMonthlyAmount($month); ?> <span class="currency_icon">m</span></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td><?= Yii::t('app', 'Ümumi ödəniş'); ?></td>
                                        <?php foreach ($albali->getMonths() as $month) { ?>
                                            <td><?= $albali->getTotalAmount($month); ?> <span class="currency_icon">m</span></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <?php $bolkart = new Bolkart($product->price); ?>
                        <div>
                            <h4>Bolkart</h4>
                            <table>
                                <thead>
                                <tr>
                                    <td>&nbsp;</td>
                                    <?php foreach ($bolkart->getMonths() as $month) { ?>
                                        <td><?= $month; ?> <?= Yii::t('app', 'AY'); ?></td>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= Yii::t('app', 'Aylıq ödəniş'); ?></td>
                                    <?php foreach ($bolkart->getMonths() as $month) { ?>
                                        <td><?= $bolkart->getMonthlyAmount($month); ?> <span class="currency_icon">m</span></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Ümumi ödəniş'); ?></td>
                                    <?php foreach ($bolkart->getMonths() as $month) { ?>
                                        <td><?= $bolkart->getTotalAmount($month); ?> <span class="currency_icon">m</span></td>
                                    <?php } ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                            <span class="icon" style="background-image: url('/uploads/options/16/red.png');"></span>
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
            </div>
        </div>
    </div>
    <div class="product_additional">
        <div class="product_infos">
            <div class="tabs">
                <ul>
                    <li><a href="#" class="active"><?= Yii::t('app', 'Product description'); ?></a></li>
                    <li><a href="#"><?= Yii::t('app', 'Reviews'); ?></a></li>
                </ul>
            </div>
            <div class="inner">
                <div class="active">
                    <?= $product->description; ?>
                </div>
                <div>
                    <div class="reviews_block">
                        <div class="reviews_list">
                            <article>
                                <div class="left_info">
                                    <div class="rating">
                                        <span class="star_2"></span>
                                    </div>
                                    <h4>Aygün Qarayeva</h4>
                                    <time>03/12/2014</time>
                                </div>
                                <div class="text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, dignissimos quia nesciunt voluptatum officiis. Quis sint delectus nostrum totam, nisi veniam fugit. Nam alias ducimus consectetur similique beatae fugit inventore. Reprehenderit cum quibusdam non expedita sit, ad tempore doloribus illum sint, nam quis commodi, ea nulla eaque, odit assumenda velit?</p>
                                </div>
                            </article>
                            <article>
                                <div class="left_info">
                                    <div class="rating">
                                        <span class="star_2"></span>
                                    </div>
                                    <h4>Aygün Qarayeva</h4>
                                    <time>03/12/2014</time>
                                </div>
                                <div class="text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, dignissimos quia nesciunt voluptatum officiis. Quis sint delectus nostrum totam, nisi veniam fugit. Nam alias ducimus consectetur similique beatae fugit inventore. Reprehenderit cum quibusdam non expedita sit, ad tempore doloribus illum sint, nam quis commodi, ea nulla eaque, odit assumenda velit?</p>
                                </div>
                            </article>
                            <article>
                                <div class="left_info">
                                    <div class="rating">
                                        <span class="star_2"></span>
                                    </div>
                                    <h4>Aygün Qarayeva</h4>
                                    <time>03/12/2014</time>
                                </div>
                                <div class="text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, dignissimos quia nesciunt voluptatum officiis. Quis sint delectus nostrum totam, nisi veniam fugit. Nam alias ducimus consectetur similique beatae fugit inventore. Reprehenderit cum quibusdam non expedita sit, ad tempore doloribus illum sint, nam quis commodi, ea nulla eaque, odit assumenda velit?</p>
                                </div>
                            </article>
                            <article>
                                <div class="left_info">
                                    <div class="rating">
                                        <span class="star_2"></span>
                                    </div>
                                    <h4>Aygün Qarayeva</h4>
                                    <time>03/12/2014</time>
                                </div>
                                <div class="text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, dignissimos quia nesciunt voluptatum officiis. Quis sint delectus nostrum totam, nisi veniam fugit. Nam alias ducimus consectetur similique beatae fugit inventore. Reprehenderit cum quibusdam non expedita sit, ad tempore doloribus illum sint, nam quis commodi, ea nulla eaque, odit assumenda velit?</p>
                                </div>
                            </article>
                        </div>
                        <div class="add_review_button"><a href="#" class="open_comment_modal">RƏY BİLDİR</a></div>
                    </div>
                </div>

            </div>
        </div>
        <aside class="aside_products">

            <h2><?= Yii::t('app', 'Satıcının digər məhsulları'); ?></h2>

            <?= $this->render('@app/views/blocks/seller_products_column', [
                'seller'    => $product->seller,
                'limit'     => 2
            ]); ?>

        </aside>
    </div>
</div>