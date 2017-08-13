<?php

use frontend\components\taksit\Albali;
use frontend\components\taksit\Bolkart;

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
                        <div class="mega_seller"><img src="/img/mega_seller.png" alt=""></div>
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
                            <b><?= $product->price; ?><i class="currency_icon">m</i></b>
                        </div>
                        <ul>
                            <li>İstehsalçı ölkə:  <b>Türkiyə</b></li>
                            <li>Original:  <b>Xeyr</b></li>
                            <li>Zəmanət:  <b>Xeyr</b></li>
                            <li>Material:  <b>Pambıq</b></li>
                            <li>Etiketlər:  <b>Telefon, Smartphone, Samsung S8</b></li>
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
                    <div class="product_size">
                        <p>Ölçü:</p>
                        <ul>
                            <li>
                                <label>
                                    <input type="radio" name="size_name" checked>
                                    <span>S</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="size_name">
                                    <span>M</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="size_name">
                                    <span>L</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="size_name">
                                    <span>XL</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="product_color">
                        <p>Rəng:</p>
                        <ul>
                            <li><a href="#" style="background: #ff5656"></a></li>
                            <li><a href="#" style="background: #20ad63" class="active"></a></li>
                            <li><a href="#" style="background: #ffd800"></a></li>
                            <li><a href="#" style="background: #393939"></a></li>
                        </ul>
                    </div>
                    <div class="product_buy_last">
                        <div class="buttons">
                            <a href="#" class="add">SƏBƏTƏ ƏLAVƏ ET</a>
                            <a href="#" class="buy">İNDİ ƏLDƏ ET</a>
                            <a href="#" class="add_to_favorites"></a>
                            <a href="#" class="compare">Məhsulu müqayisə et</a>
                        </div>
                        <div class="delivery">
                            <p>Çatdırılma:</p>
                            <span>1 - 3 iş günü ərzində <a href="#">Ətraflı</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product_additional">
        <div class="product_infos">
            <div class="tabs">
                <ul>
                    <li><a href="#" class="active">Məhsulun təsviri</a></li>
                    <li><a href="#">Rəylər</a></li>
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
            <article itemscope="" itemtype="http://schema.org/Product">
                <div>
                    <div class="image"><img src="upload/Images/10.jpg" alt="" itemprop="image"></div>
                    <h3 itemprop="name">Puma Epoch Black Lifestyle Casual Shoes</h3>
                    <div class="price"><span itemprop="price">48 <b class="currency_icon">m</b></span></div>
                    <div class="old_price">
                        <span>Qiymət: <em>58<b class="currency_icon">m</b></em></span>
                        <strong>73% OFF</strong>
                    </div>
                    <div class="rating">
                        <span class="star_2"></span>
                    </div>
                </div>
                <a href="#"></a>
            </article>
        </aside>
    </div>
</div>