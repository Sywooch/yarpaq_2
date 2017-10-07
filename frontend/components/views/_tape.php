<?php $currency = Yii::$app->currency; ?>
<div class="product_carusel">
    <div class="swipe">
        <ul>
            <?php foreach ($products as $product) { ?>
            <li>
                <div>
                    <div class="image">
                        <img src="<?= $product->preview->url; ?>" alt="<?= $product->title; ?>">
                    </div>

                    <h3><?= $product->title; ?></h3>
                    <div class="price">
                        <span>
                            <?= $currency->convertAndFormat($product->realPrice, $product->currency); ?>
                        </span>
                    </div>
                    <?php if ($product->hasDiscount()) { ?>
                    <div class="old_price">
                        <span class="price_value">
                            <?= Yii::t('app', 'Qiymət');?>:
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

                    <?php if ($product->hasDiscount()) { ?>
                        <span class="discount_i"><?= Yii::t('app', 'Discount'); ?></span>
                    <?php } ?>

                    <?php if ($product->isNew()) { ?>
                        <span class="new_i"><?= Yii::t('app', 'New'); ?></span>
                    <?php } ?>
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