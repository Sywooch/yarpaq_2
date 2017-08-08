
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
                    <div class="price"><span class="currency_icon"><?= $product->price; ?> M</span></div>
                    <?php if (false) { // if hasDiscount() ?>
                    <div class="old_price">
                        <span><?= Yii::t('app', 'Qiymət');?>: <em class="currency_icon"><?= $product->price; ?> M</em></span>
                        <strong><?= $product->discount; ?> <i class="currency_icon">m</i> <?= Yii::t('app', 'OFF'); ?></strong>
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