<?php

$currency = Yii::$app->currency;

?>
<div class="product_block">
    <header>

        <!-- Breadcrumbs -->
        <?= $this->render('@app/views/blocks/breadcrumb', [
            'currentPageTitle' => $info->title
        ]); ?>
        <!-- Breadcrumbs END -->

    </header>

    <div class="product_additional">
        <div class="product_infos">
            <div class="tabs">
                <ul>
                    <li><a href="#"><?= $info->title; ?></a></li>
                </ul>
            </div>
            <div class="inner">
                <div class="active">
                    <?= $info->content->body; ?>
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