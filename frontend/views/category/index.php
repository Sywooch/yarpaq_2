<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30 no-padding-xs">

        <div class="container no-padding">
            <div class="row">


                <aside class="col-sm-4 col-md-3 hidden-xs">

                    <div class="infoMenuBox light-gray_bg filterProductBox">
                        <div class="filter-btn">
                            <?= Yii::t('app', 'Filter'); ?>
                            <i class="fa fa-angle-up pull-right"> </i>
                        </div>
                        <div class="list-infoMenu">

                            <!-- Breadcrumbs -->
                            <?= $this->render('_breadcrumb', [
                                'category' => $category,
                                'productsCount' => $pages->totalCount
                            ]); ?>
                            <!-- Breadcrumbs END -->



                            <ul class="sub-infoMenu" style="display: block;">


                                <li>
                                    <span class="title-filter"><?= Yii::t('app', 'Price range'); ?></span>
                                    <input type="text" id="range_02" name="ProductFilter[price]" value=""
                                           data-min="<?=$productFilter->price_min?>"
                                           data-max="<?=$productFilter->price_max?>"
                                           data-from="<?= $productFilter->price_from ? $productFilter->price_from : $productFilter->price_min; ?>"
                                           data-to="<?= $productFilter->price_to ? $productFilter->price_to : $productFilter->price_max; ?>"
                                        >
                                </li>

                                <li>
                                    <span class="title-filter"> <?= Yii::t('app', 'Condition');?></span>
                                    <ul>
                                        <li>
                                            <input class="radio condition_filter" id="radio1" name="ProductFilter[condition]" type="radio" value="1" <?php if ($productFilter->condition == 1) echo 'checked'; ?>>
                                            <label for="radio1"> <?= Yii::t('app', 'New');?></label>
                                        </li>
                                        <li>
                                            <input class="radio condition_filter" id="radio2" name="ProductFilter[condition]" type="radio" value="2" <?php if ($productFilter->condition == 2) echo 'checked'; ?>>
                                            <label for="radio2"> <?= Yii::t('app', 'Used');?></label>
                                        </li>
                                    </ul>
                                </li>

                                <?php if (count($filterBrands)) { ?>

                                <li>
                                    <span class="title-filter"><?= Yii::t('app', 'Brand'); ?></span>

                                    <ul>
                                        <?php foreach ($filterBrands as $brand) { ?>
                                        <li>
                                            <input class="radio" id="radio<?= $brand->id; ?>" name="ProductFilter[brand]" type="radio" value="<?= $brand->id; ?>" <?php if ($productFilter->brand == $brand-id) echo 'checked'; ?>>
                                            <label for="radio5"> <?= $brand->title; ?></label>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <?php } ?>


                                <li>
                                    <button class="btn btn-green reset_filter"><?= Yii::t('app', 'Reset filter'); ?></button>
                                </li>
                            </ul>


                        </div>
                    </div>

                    <!-- Recently viewed -->
                    <?php if (!Yii::$app->user->isGuest) { ?>
                    <div class="some-products  green  categoryProducts hidden-xs hidden-sm" style="margin-right: 20px">
                        <div class="box-heading">
                            <h4><?= Yii::t('app', 'Recently viewed'); ?></h4>
                        </div>
                        <div>
                            <div class="col-md-12">
                                <div class="productinfo-wrapper">

                                    <div class="product_image">
                                        <a href="#">
                                            <img src="/img/last-whatch1.png" alt="Favourable unreserved nay" title=" Favourable unreserved nay " width="100%">
                                        </a>

                                        <div class="hover-info">
                                            <ul class="product-icons list-inline">
                                                <li><a> <i class="wishes-icon" data-text="add to wishes"></i></a></li>
                                                <li><a> <i class="views-icon" data-text="sürətli baxış"></i></a></li>
                                                <li><a> <i class="plus-icon" data-text="unknown"></i></a></li>
                                            </ul>
                                            <div class="hover_text"> </div>
                                        </div>
                                    </div>

                                    <p class="g-title">JBL Portable Speaker</p>
                                    <span class="g-price">425.00  <b class="manatFont">M</b></span>


                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- Recently viewed END -->
                </aside>
                <div class="col-sm-8 col-md-9">
                    <div class="row margin-right-0">

                        <div class="content-box-heading3 light-gray_bg clearfix">

                            <h6 class="pull-left hide"><?= Yii::t('app', 'View mode'); ?></h6>
                            <div class="pull-right filter-btn">
                                <?= Yii::t('app', 'Filter'); ?>
                                <i class="fa fa-angle-down pull-right"> </i>
                            </div>
                            <div class="product-filter_elem pull-left hide">
                                <div class="button-view">
                                    <button type="button" id="grid-view" class="active"><i class="fa fa-th"></i></button>
                                    <button type="button" id="list-view"><i class="fa fa-th-list"></i></button>
                                </div>
                            </div>

                            <div class="pull-right no-padding hidden-xs">
                                <div class="limit-product">
                                    <?= Yii::t('app', 'Items per page'); ?>
                                    <div class="form-group">
                                        <label class="select">
                                            <select class="form-control" id="ProductFilterPerPage">
                                                <?php foreach ($productFilter->perPageOptions as $perPageOption) { ?>
                                                <option <?= $productFilter->per_page == $perPageOption ? 'selected' : '';?> ><?=$perPageOption?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="sort-product">
                                    <?= Yii::t('app', 'Sort'); ?>
                                    <div class="form-group">
                                        <label class="select">
                                            <select class="form-control" id="ProductFilterSort">
                                                <?php foreach ($productFilter->sortOptions as $sortOptionValue => $sortOptionLabel) { ?>
                                                <option <?= $productFilter->sort == $sortOptionValue ? 'selected' : '';?> value="<?=$sortOptionValue?>"><?= $sortOptionLabel ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>

                                <div class="product-compare hide">
                                    <a href="#" class="btn  green">Məhsulun Müqaisəsi - 9</a>
                                </div>
                            </div>

                        </div>

                        <div class="row some-products categoryProducts categoryProductsAll">

                            <?php if (count($products)) { ?>


                                <?php foreach ($products as $product) { ?>
                                <div class="productinfo-wrapper col-lg-3 col-md-3 col-sm-4 col-xs-4">

                                    <div class="product_image">

                                        <a href="<?= $product->url; ?>" style="background-image: url('<?= @$product->gallery[0]->url ?>')">
                                            <?php if ($product->isNew()) { ?>
                                            <div class="new-product">
                                                <span class="dejavu-bold"><?= Yii::t('app', 'New'); ?></span>
                                            </div>
                                            <?php } ?>
                                            <!--
                                            <div class="discount">
                                                <span class="dejavu-bold">%</span>
                                            </div>
                                            -->
                                            <img src="<?= @$product->gallery[0]->url ?>" alt="Favourable unreserved nay" title=" Favourable unreserved nay " class="hide">
                                        </a>

                                        <div class="hover-info hide">
                                            <ul class="product-icons list-inline">
                                                <li><a> <i class="wishes-icon" data-text="add to wishes"></i></a></li>
                                                <li><a> <i class="views-icon" data-text="sürətli baxış"></i></a></li>
                                                <li><a> <i class="plus-icon" data-text="unknown"></i></a></li>
                                            </ul>
                                            <div class="hover_text"> </div>
                                        </div>
                                    </div>
                                    <div class="product_info">

                                        <p class="g-title"><a href="<?= $product->url ?>"><?= $product->title; ?></a></p>
                                        <span class="g-price"><?= $product->price; ?> <b class="manatFont">M</b></span>
                                        <div class="g-description"><?= html_entity_decode($product->description); ?></div>

                                        <div>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            <i class="fa fa-star-o "></i>
                                            <i class="fa fa-star-o "></i>
                                            <i class="fa fa-star-o "></i>
                                            <i class="fa fa-star-o "></i>
                                        </div>

                                        <div class="product-colors">
                                            <div><span class="yellowBg"></span></div>
                                            <div><span class="greenBg"></span></div>
                                            <div><span class="brownBg"></span></div>
                                            <div><span class="blackBg"></span></div>
                                        </div>

                                    </div>
                                    <div class="operations-order">
                                        <button class="product-add">Səbətə at</button>
                                        <div class="hidden-xs hidden-sm">
                                            <div class=" text-center">
                                                <ul class="product-icons list-inline">
                                                    <li><a> <i class="wishes-icon" data-text="add to wishes"></i></a></li>
                                                    <li><a> <i class="views-icon" data-text="sürətli baxış"></i></a></li>
                                                    <li><a> <i class="plus-icon" data-text="unknown"></i></a></li>
                                                </ul>
                                                <div class="hover_text"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>

                            <?php } else { ?>

                                <div class="col-xs-12">
                                    <p><?= Yii::t('app', 'No results'); ?></p>
                                </div>

                            <?php } ?>

                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <?php
                            echo \frontend\components\CustomLinkPager::widget([
                                'pagination'    => $pages,
                                'options'       => [
                                    'class' => 'yrpq pagination pagination pagination-sm'
                                ]
                            ]);
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>