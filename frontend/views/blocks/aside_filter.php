<?php

if (isset($category)) {
$children = $category->getChildren()->all(); ?>

    <header class="mobile_header">
        <h3><?= Yii::t('app', 'Filter'); ?></h3>
    </header>

<?php if (count($children)) { ?>
    <div class="aside_categories">
        <h3><span><?= Yii::t('app', 'Subcategories'); ?></span></h3>
        <ul>

            <?php

            $category_repo = new \frontend\models\CategoryRepository();
            $category_repo->visibleOnTheSite();
            $category_repo->andWhere(['parent_id' => $category->id]);
            foreach ($category_repo->all() as $childCategory) { ?>
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

        <?php //if ($count > 1) { ?>
        <section>
            <h3><span><?= Yii::t('app', 'Price range'); ?></span></h3>
            <div>
                <?php if (false) { ?>
                <input type="text" class="price-range" value=""
                       data-min="<?=$productFilter->price_min?>"
                       data-max="<?=$productFilter->price_max?>"
                       data-from="<?= $productFilter->price_from ? $productFilter->price_from : $productFilter->price_min; ?>"
                       data-to="<?= $productFilter->price_to ? $productFilter->price_to : $productFilter->price_max; ?>"
                    >
                <?php } ?>
                <div class="price_form">
                    <input type="text" class="price_filter" name="ProductFilter[price_from]"
                           value="<?= $productFilter->price_from; ?>">
                    <input type="text" class="price_filter" name="ProductFilter[price_to]"
                           value="<?= $productFilter->price_to; ?>">
                    <button type="submit"><?= Yii::t('app', 'Search'); ?></button>
                </div>
            </div>
        </section>
        <?php //} ?>

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

        <?php

        if (isset($options) && count($options)) {
            foreach ($options as $option_id => $option_name) { ?>

            <section>
                <h3>
                    <span><?= $option_name; ?></span>
                    <a href="#" class="option-values-reset-btn" data-option-id="<?=$option_id?>"><?= Yii::t('app', 'Reset'); ?></a>
                </h3>
                <div>
                    <ul class="checkboxes colored">

                        <?php foreach ($optionValues[$option_id] as $optionValueID => $optionValue) { ?>
                        <li>
                            <label>
                                <input
                                    type="checkbox"
                                    name="ProductFilter[optionValues][]"
                                    value="<?=$optionValueID?>"
                                    <?php if ($productFilter->hasOptionValue($optionValueID)) echo 'checked'; ?>
                                    class="option_value_filter option_value_filter_<?=$option_id?>">
                                <em></em>
                                <?php if ($optionValue['image']) { ?>
                                    <i style="background: url('http://media.yarpaq.az/image/options/<?= $optionValue['image'] ?>') no-repeat; background-size: 100%;"></i>
                                <?php } ?>
                                <span><?= $optionValue['name'] ?></span>
                                <!--<strong>234</strong>-->
                            </label>
                        </li>
                        <?php } ?>

                    </ul>
                </div>
            </section>

            <?php } ?>
        <?php } ?>

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
    </form>
</div>

<footer>
    <a href="#"><?= Yii::t('app', 'Close'); ?></a>
</footer>