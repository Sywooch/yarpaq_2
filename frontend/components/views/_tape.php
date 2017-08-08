
<div class="product_carusel">
    <div class="swipe">
        <ul>
            <?php foreach ($products as $product) { ?>
            <li>
                <div>
                    <div class="image">
                        <img src="<?= @$product->gallery[0]->url; ?>"
                             alt="<?= $product->title; ?>"
                             title="<?= $product->title; ?>">
                    </div>
                    <h3><?= $product->title; ?></h3>
                    <div class="price"><span><?= $product->price; ?> <b class="currency_icon">m</b></span></div>
                    <?php if ($product->hasDiscount()) { ?>
                    <div class="old_price">
                        <span><?= Yii::t('app', 'Qiymət');?>: <em><?= $product->price; ?><b class="currency_icon">m</b></em></span>
                        <b class="discount"><?= $product->discount; ?> <i class="currency_icon">m</i> <?= Yii::t('app', 'OFF'); ?></b>
                    </div>
                    <?php } ?>
                    <div class="rating">
                        <span class="star_<?= $product->rating; ?>"></span>
                    </div>
                </div>
                <a href="<?= $product->url; ?>"></a>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="arrows">
        <a href="#" class="prev"></a>
        <a href="#" class="next"></a>
    </div>
</div>