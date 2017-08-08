<div class="product_block">
    <header>

        <!-- Breadcrumbs -->
        <?= $this->render('_breadcrumb', [
            'category' => $category,
            'productsCount' => $pages->totalCount
        ]); ?>
        <!-- Breadcrumbs END -->

        <div class="trend_searches" style="display: none;">
            <p>Trend axtarışlar:</p>
            <ul>
                <li><a href="#">adidas</a></li>
                <li><a href="#">nike</a></li>
                <li><a href="#">puma</a></li>
                <li><a href="#">klassik kişi ayaqqabıları</a></li>
                <li><a href="#">nike airmax</a></li>
                <li><a href="#">puma rihanna</a></li>
                <li><a href="#">tərliklər</a></li>
                <li><a href="#">bot ayakkabı</a></li>
            </ul>
        </div>
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

            <?php
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
            <?php } ?>

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

                    <section style="display: none;">
                        <h3><span>Rəng</span><a href="#">təmİzlə</a></h3>
                        <div>
                            <ul class="checkboxes colored">
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <i style="background: #ff5656"></i>
                                        <span>Qırmızı</span>
                                        <strong>12</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <i style="background: #20ad63"></i>
                                        <span>Yaşıl</span>
                                        <strong>354</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <i style="background: #ffd800"></i>
                                        <span>Sarı</span>
                                        <strong>33</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <i style="background: #393939"></i>
                                        <span>Qara</span>
                                        <strong>4</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <i style="background: #567fff"></i>
                                        <span>Göy</span>
                                        <strong>421</strong>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </section>
                    <section style="display: none;">
                        <h3><span>Ölçü</span><a href="#">təmİzlə</a></h3>
                        <div>
                            <ul class="checkboxes">
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>35</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>36</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>37</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>38</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>39</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>40</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>41</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox">
                                        <em></em>
                                        <span>42</span>
                                        <strong>234</strong>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </section>

                </form>
            </div>
        </aside>
        <div class="product_list">
            <header>
                <div class="first">
                    <h2><?= $category->title; ?> <span>(1200 məhsul)</span></h2>
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
                                <b>120 azn — 300 azn<a href="#"></a></b>
                            </li>
                            <li>
                                <span>Brand:</span>
                                <b>Adidas<a href="#"></a></b>
                            </li>
                            <li>
                                <span>Rəng:</span>
                                <b>Qırmızı<a href="#"></a></b>
                            </li>
                            <li>
                                <span>Ölçü:</span>
                                <b>40<a href="#"></a></b>
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