<?php
$currency = Yii::$app->currency;
$productImages = $product->gallery;

if (count($productImages)) {
    $preview = $productImages[0]->preview;
    $previewRetina = $productImages[0]->standard;
} else { // заглушка
    $preview = $product->preview;
    $previewRetina = $product->preview;
}
?>
<article>
    <div class="image">
        <a href="<?= $product->url; ?>">
            <img src="<?= $preview->url; ?>"
                 srcset="<?= $previewRetina->url; ?> 2x"
                 alt="">
        </a>
    </div>
    <h3><a href="<?= $product->url; ?>"><?= $product->title; ?></a></h3>
    <div class="price">
        <span>
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
            <?= $currency->convertAndFormat($product->realPrice - $product->oldPrice, $product->currency); ?>
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