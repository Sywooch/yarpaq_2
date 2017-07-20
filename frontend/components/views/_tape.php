
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
                    <div class="price"><span><?= $product->price; ?> AZN</span></div>
                    <?php if (false) { // if hasDiscount() ?>
                    <div class="old_price">
                        <span><?= Yii::t('app', 'Qiymət');?>: <em><?= $product->price; ?> AZN</em></span>
                        <strong>73% OFF</strong>
                    </div>
                    <?php } ?>
                    <div class="rating">
                        <span class="star_3"></span>
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