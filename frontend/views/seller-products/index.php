<div class="product_block">
    <?= $this->render('@app/views/blocks/mobile_filter', [
        'productFilter' => $productFilter,
        'filterBrands'  => $filterBrands,
        'count'         => $count
    ]); ?>

    <div class="product_list_wrapper">

        <aside class="aside_filter">
            <?= $this->render('@app/views/blocks/aside_filter', [
                'productFilter' => $productFilter,
                'filterBrands' => $filterBrands
            ]); ?>
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
                    <?php
                    echo $this->render('@app/views/blocks/applied_filters', [
                        'productFilter' => $productFilter,
                        'filterBrands' => $filterBrands
                    ]);
                    ?>
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
                <?= $this->render('@app/views/blocks/load_more_btn', [
                    'pagination' => $pages,
                    'next_page_url' => $next_page_url
                ]); ?>
                <?= $this->render('@app/views/blocks/pagination', ['pagination' => $pages]); ?>
            </div>

        </div>
    </div>

</div>