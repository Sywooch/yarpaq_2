<article itemscope itemtype="http://schema.org/Product">
    <div class="image">
        <a href="<?= $product->url; ?>">
            <img src="<?= $product->preview; ?>" alt="" itemprop="image">
        </a>
    </div>
    <h3><a href="<?= $product->url; ?>" itemprop="name"><?= $product->title; ?></a></h3>

    <meta itemprop="priceCurrency" content="AZN" />

    <div class="price">
        <span itemprop="price"><?= $product->price; ?> <strong>m</strong></span>
    </div>

    <?php if ($product->hasDiscount()) { ?>
    <div class="old_price">
        <span><?= Yii::t('app', 'Price'); ?>: <em><?= $product->oldPrice; ?><strong>m</strong></em></span>
        <strong><?= $product->discount; ?> <i class="currency_icon">m</i> <?= Yii::t('app', 'OFF'); ?></strong>
    </div>
    <?php } ?>

    <div class="rating">
        <span class="star_<?= $product->rating; ?>"></span>
    </div>
    <?php if ($product->isNew()) { ?>
        <span class="new_i"><?= Yii::t('app', 'New'); ?></span>
    <?php } ?>

    <?php if ($product->hasDiscount()) { ?>
        <span class="discount_i"><?= Yii::t('app', 'Discount'); ?></span>
    <?php } ?>

</article>