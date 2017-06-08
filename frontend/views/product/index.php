<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30">

        <div class="container no-padding">
            <div class="row">
                <aside class="col-sm-4 col-md-3 col-sm-3 hidden-xs">
                    <div class="infoMenuBox light-gray_bg filterProductBox">
                        <div class="list-infoMenu">

                            <!-- Breadcrumbs -->
                            <?php

                            if (count($product->categories)) {
                                echo $this->render('_breadcrumb', [
                                    'category' => $product->categories[0]
                                ]);
                            }
                            ?>
                            <!-- Breadcrumbs END -->

                        </div>
                    </div>
                    <div class="some-products green categoryProducts" style="margin-right: 20px">
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
                <div class="col-sm-12 col-md-9">
                    <div class="row margin-right-0">
                        <div class="name-pr2">
                            <h3 class="green name-pr"><?= $product->title; ?></h3>
                            <p class="type-pr">Portativ Səs Sistemləri</p>
                        </div>
                        <div class="col-md-6 col-sm-12 no-padding zoomsArea">

                            <section class="center slider hidden-lg hidden-sm hidden-md">
                                <?php foreach ($product->gallery as $image) { ?>
                                <div>
                                    <img src="<?= $image->url ?>" class="img-responsive">
                                </div>
                                <?php } ?>
                            </section>

                            <div class="row padding-right-20 hidden-xs">
                                <a href="<?= $product->gallery[0]->url ?>" class="cloud-zoom" id="cloudZoom">
                                    <img src="<?= $product->gallery[0]->url ?>" class="img-responsive">
                                </a>

                                <ul class="recent_list">

                                    <?php foreach ($product->gallery as $image) { ?>
                                    <li class="photo_container col-xs-3 no-padding">
                                        <a href="<?= $image->url ?>" rel="useZoom: 'cloudZoom', smallImage: '<?= $image->url ?>'" class="cloud-zoom-gallery">
                                            <img itemprop="image" src="<?= $image->url ?>" class="img-responsive">
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 description-product  one-product-descript no-padding">


                            <div class="name-pr1">
                                <h3 class="green name-pr"><?= $product->title; ?></h3>
                                <?php if (count($product->categories)) { ?>
                                <p class="type-pr"><?= $product->categories[0]->title; ?></p>
                                <?php } ?>
                            </div>
                            <div class="info-pr">
                                <div class="row">
                                    <div class="col-md-8 col-xs-7">
                                        <p><?= Yii::t('app', 'Product code'); ?>: <span><?= $product->id; ?></span></p>
                                        <p><?= Yii::t('app', 'Store');?>:
                                            <a class="green" href="#" title="<?= Yii::t('app', 'see other products'); ?>">
                                                <span class="green dejavu-bold"><?= $product->seller->fullname; ?></span><br>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-xs-5 no-padding hide">
                                        <p>Baxışların sayı: <span>1507</span></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="stars-area">
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                <i class="fa fa-star-o "></i>
                                <i class="fa fa-star-o "></i>
                                <i class="fa fa-star-o "></i>
                                <i class="fa fa-star-o "></i>
                            </div>

                            <div>
                                <del class="del-price green hide">1090.99 <span class="manatFont">M</span></del>
                                <span class="g-price sizex26"><?= $product->price; ?> <b class="manatFont">M</b></span>
                            </div>

                            <div class="col-md-8 no-padding">
                                <div class="v-margin-15 product-colors  col-md-6 no-padding hide">
                                    <div><span class="yellowBg"></span></div>
                                    <div><span class="greenBg"></span></div>
                                    <div><span class="brownBg"></span></div>
                                    <div><span class="blackBg"></span></div>
                                </div>

                                <div class="col-md-6 no-padding-right hidden-xs hidden-sm hide">
                                    <span class="light-gray2">Mövcutluğu: 99</span>
                                </div>


                                <div class="clearfix"></div>
                                <div class="col-xs-6  padding-right-2  no-padding-left hide">
                                    <button class="simple_gray_btn ">
                                        <i class="cart-icon iconBag"> </i>
                                        <span><?= Yii::t('app', 'Add to basket'); ?></span>
                                    </button>
                                </div>
                                <div class=" col-xs-6 padding-left-2  no-padding-right hide">
                                    <button class="simple_gray_btn">
                                        <i class="fa fa-heart"></i>
                                        <span><?= Yii::t('app', 'Add to wishlist'); ?></span>
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                                <div class=" clearfix v-margin-20">
                                    <div class="quantity quantity2 col-md-6 padding-right-2  no-padding-left">
                                        <label><?= Yii::t('app', 'Quantity'); ?></label>
                                        <div class="le-quantity pull-right">
                                            <form>
                                                <a class="sp-minus" href="#reduce">-</a>
                                                <input class="quantity-input" name="quantity-input" readonly="readonly" value="1" type="text">
                                                <a class="sp-plus" href="#add">+</a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class=" col-md-6 padding-left-2 no-padding-right">
                                        <button class="btn btn-green"><?= Yii::t('app', 'Add to basket'); ?></button>
                                    </div>

                                </div>
                            </div>


                            <div class="clearfix"></div>
                            <div class="taksit-calculator">
                                <div class="caption-for-taksit"><?= Yii::t('app', 'Taksit calculator'); ?></div>
                                <table class="full-width">
                                    <thead>
                                    <tr>
                                        <td></td>
                                        <td>1 AY</td>
                                        <td>6 AY</td>
                                        <td>12 AY</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Aylıq ödəniş	</td>
                                        <td>32.83 ₼</td>
                                        <td>11.21 ₼ </td>
                                        <td>5.81 ₼</td>
                                    </tr>
                                    <tr>
                                        <td>Ümumi qiymə</td>
                                        <td>32.83 ₼</td>
                                        <td>11.21 ₼ </td>
                                        <td>5.81 ₼</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="otherInfoProduct">
                                <div class="clearfix">

                                    <div class="col-xs-4 gray_light-gray ">
                                        <p><?= Yii::t('app', 'Condition'); ?>: <span><?= Yii::t('app', $product->condition); ?></span></p>
                                        <p><?= Yii::t('app', 'Location'); ?>: <span><?= $product->location->name; ?></span></p>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <img src="/img/security.png">
                                        <div class="sizex10  v-margin-10 gray2">
                                            <?= Yii::t('app', 'customer rights'); ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 text-center">

                                        <img src="/img/moneyback.png">
                                        <div class="sizex10 v-margin-10 gray2">
                                            <?= Yii::t('app', 'moneyback'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="product-tab margin-top-30">
                            <ul class="nav nav-tabs" role="tablist">
                                <li> <a href="#description_product" aria-controls="description_product" role="tab" data-toggle="tab">Təsvir</a> </li>

                                <li><a aria-controls="comment_product" role="tab" data-toggle="tab" href="#comment_product" aria-expanded="true">Rəylər</a>  </li>
                                <li> <a href="#faq_product" aria-controls="faq_product" role="tab" data-toggle="tab">Yeni məhsullar</a> </li>
                            </ul>
                            <div class="tab-content clearfix">
                                <div  role="tabpanel" class="tab-pane fade col-md-12"  id="description_product">
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                        ever since the 1500s, when an unknown printer took a galley of type and
                                        scrambled it to make a type specimen book. It has survived not only five
                                        centuries, but also the leap into electronic typesetting, remaining essentially
                                        unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                        containing Lorem Ipsum passages, and more recently with desktop publishing
                                        software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </p>
                                </div>
                                <div  role="tabpanel" class="tab-pane fade in active  col-md-12"  id="comment_product">

                                    <ul class="comment-list">
                                        <li>
                                            <div class="clearfix">
                                                <img src="/img/avatar.jpg">
                                                <div class="comment-body">
                                                    <div class="comment-meta">
                                                        <span class="author"><a class="green" href="#">Ad Soyad</a></span>&nbsp;
                                                        <span class="date">(12.12.2020)</span>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                                        It has survived not only five centuries, but also the leap into electronic
                                                        typesetting, remaining essentially unchanged.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="clearfix">
                                                <img src="/img/avatar.jpg">
                                                <div class="comment-body">
                                                    <div class="comment-meta">
                                                        <span class="author"><a class="green" href="#">Ad Soyad</a></span>&nbsp;
                                                        <span class="date">(12.12.2020)</span>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                                        It has survived not only five centuries, but also the leap into electronic
                                                        typesetting, remaining essentially unchanged.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="clearfix">
                                                <img src="/img/avatar.jpg">
                                                <div class="comment-body">
                                                    <div class="comment-meta">
                                                        <span class="author"><a class="green" href="#">Ad Soyad</a></span>&nbsp;
                                                        <span class="date">(12.12.2020)</span>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                                        It has survived not only five centuries, but also the leap into electronic
                                                        typesetting, remaining essentially unchanged.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="comented">
                                        <h4>Rəyinizi bildirin</h4>
                                        <textarea></textarea>
                                        <button class="btn btn-green pull-right">Göndər</button>
                                    </div>
                                </div>
                                <div  role="tabpanel" class="tab-pane fade  col-md-12"  id="faq_product">

                                </div>
                            </div>
                        </div>

                        <div class="some-products categoryProducts">
                            <div class="margin-bottom-30">

                                <div class="box-heading green">
                                    <h3>Oxşar Məhsullar</h3>
                                </div>
                            </div>
                            <div class="row categoryProductsAll">

                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">

                                        <div class="product_image">
                                            <div class="new-product">
                                                <span class="dejavu-bold">Yeni</span>
                                            </div>
                                            <div class="discount">
                                                <span class="dejavu-bold">%</span>
                                            </div>
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
                                        <div class="product_info">

                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">

                                        <div class="product_image">
                                            <a href="#">
                                                <img src="/img/last-whatch1.png" alt="Favourable unreserved nay" title=" Favourable unreserved nay " width="100%">
                                            </a>
                                            <div class="productNum">5 rənqdə mövcutdur</div>
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

                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">
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
                                        <div class="product_info">
                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">
                                        <div class="product_image">
                                            <a href="#">
                                                <img src="/img/last-whatch1.png" alt="Favourable unreserved nay" title=" Favourable unreserved nay " width="100%">
                                            </a>
                                            <div class="not_items">
                                                <div>
                                                    <div>
                                                        Mövcut deil
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product_info">

                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">
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
                                        <div class="product_info">
                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">
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
                                        <div class="product_info">
                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">
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
                                        <div class="product_info">
                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="productinfo-wrapper clearfix">
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
                                        <div class="product_info">
                                            <p class="g-title">JBL Portable Speaker</p>
                                            <p class="g-description">JBL Portable Speaker with powerful subwoofer
                                                genuine original usb bluetooth aux clock alarm
                                                table comfort premium</p>
                                            <span class="g-price">425.00  <b class="manatFont">M</b></span>
                                            <div>
                                                <i class="fa fa-star" aria-hidden="true"></i>
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
                                            <div >
                                                <div class="text-center">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>