<div class="product_header_mobile">
    <h3><?= Yii::t('app', 'Search'); ?></h3>
    <ul>
        <li>
            <a href="#" class="sort"><span><?= Yii::t('app', 'Sort'); ?></span></a>
            <select name="" id="" class="mobile-sort-by">
                <?php foreach ($productFilter->sortOptions as $sortOptionValue => $sortOptionLabel) { ?>
                    <option <?= $productFilter->sort == $sortOptionValue ? 'selected' : ''; ?> value="<?= $sortOptionValue ?>"><?= $sortOptionLabel ?></option>
                <?php } ?>
            </select>
        </li>
        <li><a href="#" class="filtre"><span><?= Yii::t('app', 'Filter'); ?></span></a></li>
    </ul>

    <p><?= Yii::t('app', 'Products found'); ?> - <?= $count; ?></p>
</div>