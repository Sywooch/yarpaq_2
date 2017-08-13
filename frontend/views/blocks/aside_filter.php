<?php

if (isset($category)) {
$children = $category->getChildren()->all();

if (count($children)) { ?>
    <div class="aside_categories">
        <h3><span><?= Yii::t('app', 'Subcategories'); ?></span></h3>
        <ul>

            <?php foreach ($category->getChildren()->all() as $childCategory) { ?>
                <li>
                    <a href="<?= $childCategory->url; ?>">
                        <span><?= $childCategory->title; ?></span>
                        <!--<em>300</em>-->
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
<?php } } ?>

<div class="filters_block">
    <?php
    /**
     * @var $productFilter frontend\models\ProductFilter
     * @var $filterBrands Array
     */
    ?>
    <form action="" id="productFilterForm">

        <?php if (isset($search_q)) { ?>
        <input type="hidden" name="q" value="<?= $search_q;?>">
        <?php } ?>

        <input
            type="hidden"
            name="ProductFilter[sort]"
            class="sort_filter"
            value="<?= $productFilter->sort; ?>">

        <section>
            <h3><span><?= Yii::t('app', 'Price range'); ?></span></h3>
            <div>
                <input type="text" class="price-range" value=""
                       data-min="<?=$productFilter->price_min?>"
                       data-max="<?=$productFilter->price_max?>"
                       data-from="<?= $productFilter->price_from ? $productFilter->price_from : $productFilter->price_min; ?>"
                       data-to="<?= $productFilter->price_to ? $productFilter->price_to : $productFilter->price_max; ?>"
                    >
                <div class="price_form">
                    <input type="text" class="price_filter" name="ProductFilter[price_from]"
                           value="<?= $productFilter->price_from; ?>">
                    <input type="text" class="price_filter" name="ProductFilter[price_to]"
                           value="<?= $productFilter->price_to; ?>">
                    <button type="submit"><?= Yii::t('app', 'Search'); ?></button>
                </div>
            </div>
        </section>

        <section>
            <h3>
                <span><?= Yii::t('app', 'Condition'); ?></span>
                <a href="#" class="condition-reset-btn"><?= Yii::t('app', 'Reset'); ?></a>
            </h3>
            <div>
                <ul class="checkboxes">
                    <li>
                        <label>
                            <input
                                id="condition-1"
                                type="radio"
                                class="condition_filter"
                                name="ProductFilter[condition]"
                                value="1"
                                <?php if ($productFilter->condition == 1) echo 'checked'; ?>>
                            <em></em>
                            <span><?= Yii::t('app', 'New');?></span>
                            <!--<strong>234</strong>-->
                        </label>
                    </li>
                    <li>
                        <label>
                            <input
                                id="condition-2"
                                type="radio"
                                name="ProductFilter[condition]"
                                class="condition_filter"
                                value="2"
                                <?php if ($productFilter->condition == 2) echo 'checked'; ?>>
                            <em></em>
                            <span><?= Yii::t('app', 'Used');?></span>
                            <!--<strong>234</strong>-->
                        </label>
                    </li>
                </ul>
            </div>
        </section>

        <?php if (count($filterBrands)) { ?>
            <section>
                <h3>
                    <span><?= Yii::t('app', 'Brand'); ?></span>
                    <a href="#" class="brand-reset-btn"><?= Yii::t('app', 'Reset'); ?></a>
                </h3>
                <div>
                    <ul class="checkboxes">
                        <?php foreach ($filterBrands as $brand) { ?>
                            <li>
                                <label>
                                    <input
                                        id="brand-<?= $brand->id; ?>"
                                        <?php if ($productFilter->hasBrand($brand->id)) echo 'checked'; ?>
                                        name="ProductFilter[brand][]"
                                        type="checkbox"
                                        value="<?= $brand->id; ?>"
                                        class="brand_filter">
                                    <em></em>
                                    <span><?= $brand->title; ?></span>
                                    <!--<strong>234</strong>-->
                                </label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </section>
        <?php } ?>

        <footer>
            <a href="#"><?= Yii::t('app', 'Close'); ?></a>
        </footer>
    </form>
</div>