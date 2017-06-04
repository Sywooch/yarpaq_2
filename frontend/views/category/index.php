<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30">

        <div class="container no-padding">
            <div class="row">


                <aside class="col-sm-4 col-md-3 hidden-xs">

                    <div class="infoMenuBox light-gray_bg filterProductBox">
                        <div class="filter-btn">
                            Filter
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
                                    <span class="title-filter">Brend</span>

                                    <ul>
                                        <li>
                                            <input class="radio" id="radio5" name="method_payment" type="radio">
                                            <label for="radio5"> Kenwood</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio6" name="method_payment" type="radio">
                                            <label for="radio6"> JBL</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio7" name="method_payment" type="radio">
                                            <label for="radio7"> Harman & Kardon</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio8" name="method_payment" type="radio">
                                            <label for="radio8">Sony</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio9" name="method_payment" type="radio">
                                            <label for="radio9">Samsung</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio10" name="method_payment" type="radio">
                                            <label for="radio10">Apple</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio11" name="method_payment" type="radio">
                                            <label for="radio11">Beats by Dre</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio12" name="method_payment" type="radio">
                                            <label for="radio12">Yamaha</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio13" name="method_payment" type="radio">
                                            <label for="radio13">Bang & Olufsen</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio14" name="method_payment" type="radio">
                                            <label for="radio14">Infinity</label>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <span class="title-filter"> Vəziyyət</span>
                                    <ul>
                                        <li>
                                            <input class="radio" id="radio3" name="method_payment" type="radio">
                                            <label for="radio3"> İşlənmiş</label>
                                        </li>
                                        <li>
                                            <input class="radio" id="radio4" name="method_payment" type="radio">
                                            <label for="radio4">     Yeni</label>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <span class="title-filter">Qiymət intervalı</span>

                                    <input type="text" id="range_02" name="range" value="" >
                                </li>
                                <li>
                                    <button class="btn btn-green">Axtarışı Təmizlə</button>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="some-products  green  categoryProducts hidden-xs hidden-sm" style="margin-right: 20px">
                        <div class="box-heading">
                            <h3>Baxılmış məhsullar</h3>
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
                </aside>
                <div class="col-sm-8 col-md-9">
                    <div class="row margin-right-0">
                        <div class="content-box-heading3 light-gray_bg clearfix">
                            <h6 class="pull-left">Görüntü</h6>
                            <div class="pull-right filter-btn">
                                Filter
                                <i class="fa fa-angle-down pull-right"> </i>
                            </div>
                            <div class="product-filter_elem pull-left">
                                <div class="button-view">
                                    <button type="button" id="grid-view" class="active"><i class="fa fa-th"></i></button>

                                    <button type="button" id="list-view"><i class="fa fa-th-list"></i></button>
                                </div>
                            </div>

                            <div class="pull-right no-padding hidden-xs">
                                <div class="limit-product">
                                    Göstər
                                    <div class="form-group">
                                        <label class="select">
                                            <select class="form-control" title="Ölkə">
                                                <option value="">26</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="sort-product">
                                    Sırala
                                    <div class="form-group">
                                        <label class="select">
                                            <select class="form-control" title="Ölkə">
                                                <option value="">yenisi</option>
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

                            <?php foreach ($products as $product) { ?>
                            <div class="productinfo-wrapper col-lg-3 col-md-3 col-sm-4 col-xs-4">

                                <div class="product_image">

                                    <a href="#">
                                        <!--
                                        <div class="new-product">
                                            <span class="dejavu-bold">Yeni</span>
                                        </div>
                                        <div class="discount">
                                            <span class="dejavu-bold">%</span>
                                        </div>
                                        -->
                                        <img src="<?= $product->gallery[0]->url ?>" alt="Favourable unreserved nay" title=" Favourable unreserved nay " width="100%">
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
                                <div class="product_info">

                                    <p class="g-title"><?= $product->title; ?></p>
                                    <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                        genuine original usb bluetooth aux clock alarm
                                        table comfort premium</p>
                                    <span class="g-price"><?= $product->price; ?>  <b class="manatFont">M</b></span>

                                    <!--
                                    <div>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o "></i>
                                        <i class="fa fa-star-o "></i>
                                        <i class="fa fa-star-o "></i>
                                        <i class="fa fa-star-o "></i>
                                    </div>
                                    -->

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

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>