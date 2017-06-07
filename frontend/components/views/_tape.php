<div class="some-products green">
    <div class="container">
        <div class="row">

            <div class="box-heading">
                <h3><?= Yii::t('app', $mainLabel); ?>
                    <a href="#" class="all-products-link pull-right hide">
                        <span><?= Yii::t('app', $seeAllLabel); ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </h3>
            </div>

            <div class="owl-carousel owl-theme">

                <?php
                foreach ($products as $product) { ?>
                <div class="productinfo-wrapper">
                    <div class="product_image">
                        <a href="<?= $product->url; ?>">
                            <img src="<?= @$product->gallery[0]->url; ?>"
                                 alt="<?= $product->title; ?>"
                                 title="<?= $product->title; ?>"
                                 width="100%">
                        </a>

                        <div class="hover-info hide">
                            <ul class="product-icons list-inline">
                                <li><a> <i class="wishes-icon" data-text="add to wishes"></i></a></li>
                                <li><a> <i class="views-icon" data-text="sürətli baxış"></i></a></li>
                                <li><a> <i class="plus-icon" data-text="unknown"></i></a></li>
                            </ul>
                            <div class="hover_text"></div>
                        </div>
                    </div>

                    <p class="g-title"><?= $product->title; ?></p>

                    <span class="g-price"><?= $product->price; ?> <b class="manatFont">M</b></span>

                    <div class="hide">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star-o "></i>
                        <i class="fa fa-star-o "></i>
                        <i class="fa fa-star-o "></i>
                        <i class="fa fa-star-o "></i>
                    </div>
                    <button class="product-add">
                        <?= Yii::t('app', 'Add to basket'); ?>
                    </button>

                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>