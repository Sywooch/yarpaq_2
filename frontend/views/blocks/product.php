<?php $currency = Yii::$app->currency; ?>
<article itemscope itemtype="http://schema.org/Product">
    <div class="image">
        <a href="<?= $product->url; ?>">
            <img src="<?= $product->preview->url; ?>" alt="" itemprop="image">
        </a>
    </div>
    <h3><a href="<?= $product->preview->url; ?>" itemprop="name"><?= $product->title; ?></a></h3>

    <meta itemprop="priceCurrency" content="AZN" />

    <div class="price">
        <span itemprop="price">
            <?= $currency->convertAndFormat($product->realPrice, $product->currency); ?>
        </span>
    </div>

    <?php if ($product->hasDiscount()) { ?>
    <div class="old_price">
        <span class="price_value">
            <?= Yii::t('app', 'Price'); ?>:
            <em><?= $currency->convertAndFormat($product->oldPrice, $product->currency); ?></em>
        </span>
        <b class="discount">
            <?= $currency->convertAndFormat($product->oldPrice - $product->realPrice, $product->currency); ?>
            <?= Yii::t('app', 'OFF'); ?>
        </b>
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