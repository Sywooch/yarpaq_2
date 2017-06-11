<?php

use common\models\Language;
use common\models\category\Category;
use yii\helpers\Html;

$main_categories = Category::find()->andWhere(['depth' => 2])->orderBy('lft')->all();

$this->beginPage();
?>
<!DOCTYPE html>
<html>
<head lang="<?= Yii::$app->language ?>">
    <meta charset="UTF-8">
    <?= Html::csrfMetaTags() ?>
    <script>
        if (navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)) {
            document.write('<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">');
        }
    </script>
    <title>Yarpaq.az</title>
    <link rel="stylesheet" type="text/css" href="/css/base.css">

    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php $this->beginBody() ?>

<!-- Ads -->
<div class="hidden-xs hidden-sm topBanner text-center hide">
    <img src="/img/headerBg.png" alt="">
</div>
<!-- Ads END -->

<header class="header-second">
    <div class="header-top">
        <div class="container" style="padding-right: 0;">
            <div class="top-logo col-xs-12 col-md-3 col-sm-3">
                <a href="<?php echo \frontend\components\HomePageLink::widget(); ?>" title="yarpaq.az" class="logo">
                    <img src="/img/logo.png" alt="yarpaq.az logo">
                </a>
            </div>
            <div class="col-xs-9 col-sm-7 col-md-7 no-padding clearfix">
                <div class="row">
                    <form action="<?= Language::getCurrent()->urlPrefix.'/search';?>" method="get">
                        <div class="form-search">
                            <div class=" form-group form-category search_combo hidden-sm hidden-xs">

                                <div class="relative">
                                    <div class="form-group form-category search_category hidden-xs hidden-sm">
                                        <select id="search_category" name="category_id" class="chosen-select"
                                                style="width:178px">
                                            <option value=""><?= Yii::t('app', 'All sections'); ?></option>

                                            <?php foreach ($main_categories as $category) { ?>
                                                <option value="<?= $category->id; ?>"><?= $category->title; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <a href="javascript:void(0)" class="open-categorysearch-inner"></a>
                                </div>
                            </div>
                            <div class="form-group input-search input-serach">
                                <input placeholder="<?= Yii::t('app', 'Enter product name'); ?>..." class="search_query" name="q" autocomplete="off" type="text" value="<?= @htmlentities($this->params['q']); ?>">
                            </div>
                            <button type="submit" class="btn-search">
                                <i class="button-search-icon"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="currency-lang pull-right">
                <ul class="list-inline dejavu-bold">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= Language::getCurrent()->name; ?></a>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach (Language::find()->all() as $language) {
                                if ($language == Language::getCurrent()) { continue; } ?>
                                <li><a href="<?= $language->urlPrefix; ?>/"><?= $language->name; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <!--
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= Yii::$app->currency->userCurrency->code; ?></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach (Yii::$app->currency->currencies as $currency) {
                                    if ($currency == Yii::$app->currency->userCurrency) { continue; } ?>
                                    <li><a href="#"><?= $currency->code; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        -->
                </ul>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container no-padding">
            <div class="row" style="height: 31px;">
                <div class="main-categories static col-md-3 col-sm-1">
                    <div class="md-relative widget-categories">
                        <nav class="megamenus nav-vertical-left-megamenu style-2">
                            <h3 class="widget-title clearfix">

                                <a class="link-open-dropdown" href="javascript:void(0)">
                                    <i class="fa fa-bars"></i>
                                    <span class="title"><?= Yii::t('app', 'All categories'); ?></span>
                                </a>
                            </h3>

                            <a class="responsive-btn vertical-responsive" href="javascript:void(0)">
                                <i class="fa fa-bars"></i>
                            </a>
                            <ul class="desktop-nav vertical-left-megamenu menu clearfix">


                                <li class="hidden-lg hidden-md">
                                    <a class="responsive-btn vertical-responsive" href="javascript:void(0)">
                                        <i class="fa fa-bars"></i>
                                    </a>

                                    <div class="torch-green-border pull-right">
                                        <a href="https://sell.yarpaq.az/"><?= Yii::t('app', 'Begin To Sell'); ?></a>
                                    </div>
                                </li>

                                <?php foreach ($main_categories as $category) { ?>
                                <li class="megamenu-container megamenu-rows  menu-parent">
                                    <a href="<?= $category->url; ?>" data-rel="" title="<?= $category->title; ?>">
                                        <span><?= $category->title; ?></span>
                                    </a>
                                    <a class="link-open-submenu hidden-lg hidden-md"></a>

                                    <div class="megamenu menu-megacontent" style="" data-background_image="">

                                        <div class="clearfix megamenu-list">
                                            <div class="col-md-12">
                                                <h4 class="mega-group-header"
                                                    style="font-size: 20px; color: rgb(121, 178, 55);">
                                                    <?= $category->title; ?>
                                                </h4>
                                            </div>

                                            <?php
                                            $children = $category->getChildren()->all();
                                            $per_col = ceil(count($children) / 2);
                                            ?>

                                            <div class="col-md-6 megamenu_group">
                                                <ul class="menuitems">
                                                    <?php foreach (array_slice($children, 0, $per_col) as $child) { ?>
                                                    <li><a href="<?= $child->url; ?>" title="<?= $child->title; ?>"><?= $child->title; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>


                                            <div class="col-md-6 megamenu_group">
                                                <ul class="menuitems">
                                                    <?php foreach (array_slice($children, $per_col) as $child) { ?>
                                                        <li><a href="<?= $child->url; ?>" title="<?= $child->title; ?>"><?= $child->title; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>


                                        </div>

                                        <!--
                                        <div class="row clearfix megamenu-img">
                                            <div class="col-md-12  megamenu_group">
                                                <ul class="menuitems">
                                                    <li class="">
                                                        <div class="menu-item-image">
                                                            <img class="img-responsive" src="/uploads/categories/computers.png" alt=""/>

                                                            <div class="menu-item-image-des"></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        -->

                                    </div>

                                </li>
                                <?php } ?>

                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-9 col-sm-11 col-xs-12">
                    <div class="row">

                        <!--
                        <div class="secMenu pull-left col-md-8  no-padding">
                            <ul>
                                <li><a href="#">Həftəsonu Endirimlər</a></li>
                                <li class="greenBg"><a href="#">Kombo Alış-veriş</a></li>
                                <li><a href="#">Yerli Məhsullar</a></li>
                                <li class="torch-red-border hidden-xs -sm"><a href="#">Satışa Başla</a></li>
                            </ul>
                        </div>
                        -->

                        <ul class="list-inline  pull-right cart-login">
                            <li>
                                <div class="dropdown dropdown-bag">
                                    <a data-toggle="dropdown" class="cart-icon iconBag bag-link">0</a>

                                    <div class="dropdown-menu bag-drop">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h3>Səbətinizdə</h3>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 bag-scrool padding5">

                                            <div class="clearfix"></div>
                                            <div class="row margin-top-10">
                                                <div class="col-lg-7 col-md-7 col-xs-7 col-sm-7 no-padding-xs">
                                                    <div class="row">

                                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 no-padding-xs">
                                                            <img class="img-rounded" src="/img/basketFile.jpg" width="50"
                                                                 alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
                                                            <p class="g-title bag-text small ">JBL Portable Speaker JBL Portable Speaker</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-5 col-md-5 col-xs-5 col-sm-5 no-padding-xs">
                                                    <div class="row">
                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>x</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>1</span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4 no-padding-xs">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>425</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span><b
                                                                            class="manatFont">M</b></span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>
                                            <div class="row margin-top-10">
                                                <div class="col-lg-7 col-md-7 col-xs-7 col-sm-7 no-padding-xs">
                                                    <div class="row">

                                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 no-padding-xs">
                                                            <img class="img-rounded" src="/img/basketFile.jpg" width="50"
                                                                 alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
                                                            <p class="g-title bag-text small ">JBL Portable Speaker JBL
                                                                Portable Speaker</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-5 col-md-5 col-xs-5 col-sm-5 no-padding-xs">
                                                    <div class="row">
                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>x</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>1</span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4 no-padding-xs">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>425</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span><b
                                                                            class="manatFont">M</b></span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>
                                            <div class="row margin-top-10">
                                                <div class="col-lg-7 col-md-7 col-xs-7 col-sm-7 no-padding-xs">
                                                    <div class="row">

                                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 no-padding-xs">
                                                            <img class="img-rounded" src="/img/basketFile.jpg" width="50"
                                                                 alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
                                                            <p class="g-title bag-text small ">JBL Portable Speaker JBL
                                                                Portable Speaker</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-5 col-md-5 col-xs-5 col-sm-5 no-padding-xs">
                                                    <div class="row">
                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>x</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>1</span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4 no-padding-xs">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>425</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span><b
                                                                            class="manatFont">M</b></span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>
                                            <div class="row margin-top-10">
                                                <div class="col-lg-7 col-md-7 col-xs-7 col-sm-7 no-padding-xs">
                                                    <div class="row">

                                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 no-padding-xs">
                                                            <img class="img-rounded" src="/img/basketFile.jpg" width="50"
                                                                 alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
                                                            <p class="g-title bag-text small ">JBL Portable Speaker JBL
                                                                Portable Speaker</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-5 col-md-5 col-xs-5 col-sm-5 no-padding-xs">
                                                    <div class="row">
                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>x</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>1</span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4 no-padding-xs">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span>425</span></p>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <p class="g-title"><span><b
                                                                            class="manatFont">M</b></span></p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="left-line no-padding-left no-padding-right col-lg-4 col-md-4 col-xs-4 col-sm-4">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 no-padding-xs">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ======================================================================= -->
                                        </div>
                                        <!-- ======================================================================= -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 checkout-proses padding5">
                                            <hr class="white">
                                            <div class="row">
                                                <div
                                                    class="col-lg-9 col-md-9 col-sm-9 col-xs-9 no-padding-left no-padding-right">
                                                    <div
                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right">
                                                        <p class="total-price small"><span>Ümumi məbləğ:</span></p>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right">
                                                        <p class="total-price small">
                                                            <span><strong>Yekun məbləğ:</strong></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 no-padding-xs">
                                                    <div
                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding no-padding-xs">
                                                        <span class="g-price small pull-right">425.00  <b
                                                                class="manatFont">M</b></span>
                                                    </div>

                                                    <div
                                                        class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding no-padding-xs">
                                                        <strong>
                                                            <span class="g-price small pull-right">459.00 <b
                                                                    class="manatFont">M</b></span>
                                                        </strong>
                                                    </div>

                                                </div>
                                            </div>

                                            <hr class="white">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 no-padding-xs">
                                                    <a href="<?= \yii\helpers\Url::toRoute(['cart/index']); ?>" type="button" class="btn-grey btn btn-link">Səbətə keç</a>
                                                </div>

                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 no-padding-xs">
                                                    <input class="button_drop greenBg col-md-12 pull-right"
                                                           value="Sifarişi yekunlaşdır" type="submit">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </li>

                            <li>

                                <div class="dropdown dropdown-cart">
                                    <a id="access_link" data-toggle="dropdown"
                                       class="dropdown-toggle login-link <?= !Yii::$app->user->isGuest ? 'loggedIn' : ''; ?>" href="#">
                                        <?= Yii::$app->user->isGuest ? Yii::t('app', 'Sign in') : Yii::t('app', 'Account'); ?>
                                    </a>


                                    <?php if (Yii::$app->user->isGuest) { ?>
                                    <div class="dropdown-menu">
                                        <div class="col-md-12">
                                            <h4 class="margin-bottom-15 margin-top-0"><?= Yii::t('app', 'Sign in'); ?></h4>

                                            <form action="<?= Language::getCurrent()->urlPrefix; ?>/login" method="post" id="loginForm">
                                                <div class="form-group">
                                                    <input placeholder="<?= Yii::t('app', 'Email'); ?>" id="inputUsernameEmail"
                                                           class="form-control" type="text" name="LoginForm[email]">
                                                </div>
                                                <div class="form-group margin-bottom-10">
                                                    <input placeholder="<?= Yii::t('app', 'Password'); ?>" id="inputPassword" class="form-control"
                                                           type="password" name="LoginForm[password]">
                                                </div>
                                                <a href="#" class="hide" id="forgot_pw"><?= Yii::t('app', 'Restore password'); ?></a>
                                                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken()?>">
                                                <input class="button_drop greenBg pull-right" value="<?= Yii::t('app', 'Sign in'); ?>"
                                                       type="submit">

                                                <div class="clearfix"></div>
                                                <!--
                                                <div class="col-md-6 col-sm-6 col-xs-6  no-padding bt_facebook">
                                                    <a class="bt_soc " href="#">Login with Facebook </a>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6 bt_gmail no-padding">
                                                    <a class="bt_soc " href="#">Sign in with Google+</a>
                                                </div>
                                                -->
                                                <div class="clearfix"></div>
                                                <h4 class="margin-top-20 margin-bottom-10"><?= Yii::t('app', 'Join us'); ?></h4>
                                                <a href="<?= Language::getCurrent()->urlPrefix; ?>/registration" class="button_drop greenBg col-md-12"><?= Yii::t('app', 'Register'); ?></a>
                                            </form>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div class="dropdown-menu cabinet">
                                        <div class="col-md-12">

                                            <a href="#" id="orders"><?= Yii::t('app', 'Orders history'); ?></a>
                                            <div class="clearfix"></div>

                                            <a href="#" id="adresses"><?= Yii::t('app', 'Addresses'); ?></a>
                                            <div class="clearfix"></div>

                                            <a href="#" id="own_info"><?= Yii::t('app', 'Personal information'); ?></a>
                                            <div class="clearfix"></div>

                                            <a id="exit_link" class="exit-link" href="<?= Language::getCurrent()->urlPrefix;?>/logout"><?= Yii::t('app', 'Logout'); ?></a>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<?= $content; ?>

<?= $this->render('_footer'); ?>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="/js/common_scripts_min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="/js/homeslider.js"></script>
<script type="text/javascript" src="/js/owl.carousel.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/jquery.hoverIntent.js"></script>
<script type="text/javascript" src="/js/megamenus.js"></script>

<!-- Only for product page -->
<script type="text/javascript" src="/js/cloud-zoom.js"></script>

<script type="text/javascript" src="/js/jquery.chosen.js"></script>

<script src="/js/bootstrap-datepicker.js"></script>
<script>
    $('input.date-pick').datepicker('setDate', 'today');
</script>
<script src="/slick/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).on('ready', function() {

        $(".center").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 1,
            slidesToScroll: 2
        });

    });
</script>
<!-- Only for product page END -->

<script>
    $(window).load(function () {
        $("[data-toggle]").click(function () {
            var toggle_el = $(this).data("toggle");
            $(toggle_el).toggleClass("open-sidebarss");
        });
        $("#sidebarss").swipe({
            swipeStatus: function (event, phase, direction, distance, duration, fingers) {
                if (phase == "move" && direction == "right") {
                    $(".containerss").addClass("open-sidebarss");
                    return false;
                }
                if (phase == "move" && direction == "left") {
                    $(".vertical-left-megamenu").removeClass("open-sidebarss");
                    return false;
                }
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    $(document).ready(function () {
        if ($(".chosen-select").length > 0)
            $(".chosen-select").chosen();
        $(document).on('click', '.toggle-menu', function () {
            $(this).closest('.nav-menu').find('.menu-collapse').slideToggle("slow");
            return false;
        })
    })
</script>

<script type="text/javascript" src="/js/jquery.chosen.js"></script>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage() ?>