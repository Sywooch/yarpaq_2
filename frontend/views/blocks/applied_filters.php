<div class="applied_filters">
    <ul>
        <?php if ($productFilter->price_from != '' || $productFilter->price_to != '') { ?>
            <li>
                <span><?= Yii::t('app', 'Price'); ?>:</span>
                <b><?= $productFilter->price_from ?> <span class="currency_icon">M</span>
                    — <?= $productFilter->price_to ?> <span class="currency_icon">M</span>
                    <a href="#" class="selected-filter selected-filter-price"></a></b>
            </li>
        <?php } ?>

        <?php if ($productFilter->brand) { ?>
            <li>
                <span><?= Yii::t('app', 'Brand'); ?>:</span>

                <?php foreach ($filterBrands as $brand) {
                    if (!$productFilter->hasBrand($brand->id)) continue; ?>
                    <b><?= $brand->title; ?> <a href="#"
                                                class="selected-filter selected-filter-checkbox"
                                                data-id="brand-<?= $brand->id; ?>"></a></b>
                <?php } ?>
            </li>
        <?php } ?>
        <?php if ($productFilter->condition == 2) { ?>
            <li>
                <span><?= Yii::t('app', 'Condition'); ?>:</span>
                <b>
                    <?= Yii::t('app', 'Used'); ?>
                    <a href="#" class="selected-filter selected-filter-checkbox" data-id="condition-<?=$productFilter->condition;?>"></a>
                </b>
            </li>
        <?php } ?>
    </ul>
</div>