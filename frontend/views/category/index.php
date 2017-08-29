<div class="product_block">
    <header>

        <!-- Breadcrumbs -->
        <?= $this->render('@app/views/blocks/breadcrumb', [
            'parents' => $category->getParents(true)->all(),
            'currentPageTitle' => $category->title
        ]); ?>
        <!-- Breadcrumbs END -->

    </header>

    <?= $this->render('@app/views/blocks/mobile_filter', [
        'productFilter' => $productFilter,
        'filterBrands'  => $filterBrands,
        'count'         => $count
    ]); ?>

    <div class="product_list_wrapper">

        <aside class="aside_filter">
            <?= $this->render('@app/views/blocks/aside_filter', [
                'category'      => $category,
                'productFilter' => $productFilter,
                'filterBrands' => $filterBrands
            ]); ?>
        </aside>

        <div class="product_list">
            <header>
                <div class="first">
                    <h2><?= $category->title; ?> <span>(<?=$pages->totalCount?> <?php echo Yii::t('app', 'product'.\frontend\components\LanguageHelpers::plural($pages->totalCount)); ?>)</span></h2>
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
                    <?php
                    echo $this->render('@app/views/blocks/applied_filters', [
                        'productFilter' => $productFilter,
                        'filterBrands' => $filterBrands
                    ]);
                    ?>
                    <a href="#" class="clear_filtre"><?= Yii::t('app', 'Reset filter'); ?></a>
                </div>
            </header>
            <div class="product_result_list">
                <?php
                if (isset($products) && count($products)) {
                    foreach ($products as $product) {
                        echo $this->render('@app/views/blocks/product', [
                            'product' => $product
                        ]);
                    }
                } else {
                    ?>
                    <div class="no-result">
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
        </div>
    </div>

</div>