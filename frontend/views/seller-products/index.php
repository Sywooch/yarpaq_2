<div class="product_block">
    <header>



    </header>
    <div class="product_header_mobile">
        <h3>Ayyaqqabılar: İdman</h3>
        <ul>
            <li><a href="#" class="sort"><span>Çeşİdlə</span></a></li>
            <li><a href="#" class="filtre"><span>Fİlter</span></a></li>
        </ul>
        <p>Tapılan məhsullar   1 026</p>
    </div>
    <div class="product_list_wrapper">

        <aside class="aside_filter">

            <div class="filters_block">
                <?php
                /**
                 * @var $productFilter frontend\models\ProductFilter
                 * @var $filterBrands Array
                 */
                ?>
                <form action="" id="productFilterForm">

                    <input
                        type="hidden"
                        name="ProductFilter[sort]"
                        class="sort_filter"
                        value="<?= $productFilter->sort; ?>">

                    <section>
                        <h3><span><?= Yii::t('app', 'Price range'); ?></span></h3>
                        <div>
                            <input type="text" class="price-range" value=""
                                   data-step="10"
                                   data-min="<?=$productFilter->price_min?>"
                                   data-max="<?=$productFilter->price_max?>"
                                   data-from="<?= $productFilter->price_from ? $productFilter->price_from : $productFilter->price_min; ?>"
                                   data-to="<?= $productFilter->price_to ? $productFilter->price_to : $productFilter->price_max; ?>"
                                >
                            <div class="price_form">
                                <input type="text" class="price_filter" name="ProductFilter[price_from]"
                                       value="<?= $productFilter->price_from ? $productFilter->price_from : $productFilter->price_min; ?>">
                                <input type="text" class="price_filter" name="ProductFilter[price_to]"
                                       value="<?= $productFilter->price_to ? $productFilter->price_to : $productFilter->price_max; ?>">
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

                </form>
            </div>
        </aside>
        <div class="product_list">
            <header>
                <div class="first">
                    <h2><?= $seller->fullname; ?> <span>(<?= $pages->totalCount; ?>)</span></h2>
                    <div class="sort_by">
                        <a href="#"><?= Yii::t('app', 'Sort'); ?>: <span><?= $productFilter->sortOptions[ $productFilter->sort ] ?></span></a>
                        <ul>
                            <?php foreach ($productFilter->sortOptions as $sortOptionValue => $sortOptionLabel) { ?>
                                <li>
                                    <a
                                        href="#"
                                        data-value="<?=$sortOptionValue?>"
                                        <?= $productFilter->sort == $sortOptionValue ? 'class="active"' : '';?>
                                        ><?= $sortOptionLabel ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="second">
                    <div class="applied_filters">
                        <ul>
                            <li>
                                <span>Qiymət:</span>
                                <strong>120 azn — 300 azn<a href="#"></a></strong>
                            </li>
                            <li>
                                <span>Brand:</span>
                                <strong>Adidas<a href="#"></a></strong>
                            </li>
                            <li>
                                <span>Rəng:</span>
                                <strong>Qırmızı<a href="#"></a></strong>
                            </li>
                            <li>
                                <span>Ölçü:</span>
                                <strong>40<a href="#"></a></strong>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="clear_filtre"><?= Yii::t('app', 'Clear filter'); ?></a>
                </div>
            </header>
            <div class="product_result_list">
                <?php
                if (isset($products) && count($products)) {
                    foreach ($products as $product) {
                        echo $this->render('_product', [
                            'product' => $product
                        ]);
                    }
                } else {
                    ?>
                    <div class="col-xs-12">
                        <p><?= Yii::t('app', 'No results'); ?></p>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="more_products">
            <?php
            echo \frontend\components\CustomLinkPager::widget([
                'pagination'    => $pages,
                'options'       => [
                    'class' => 'pagination'
                ]
            ]);
            ?>
            </div>
            <footer>
                <span>Axtardığızı tapa bildinizmi?</span>
                <a href="#">Bəli</a>
                <a href="#">Xeyir</a>
            </footer>
        </div>
    </div>

</div>