<?php

use common\models\Language;
use common\models\category\Category;
use common\models\category\TopCategoryList;
use yii\helpers\Url;

$this->beginPage();
?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0 , user-scalable=no">
    <meta name="description" content="Yarpaq site - Full description">
    <meta name="Keywords" content="Yarpaq, Almag, Telefonlar, Shop">

    <title><?= @$page->title; ?> &mdash; Yarpaq online mağaza</title>

    <meta property="og:title" content="The Rock" />
    <meta property="og:type" content="video.movie" />
    <meta property="og:url" content="http://www.imdb.com/title/tt0117500/" />
    <meta property="og:image" content="http://ia.media-imdb.com/images/rock.jpg" />

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="icon" type="image/png" href="img/favicon.png"/>

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font/stylesheet.css" rel="stylesheet" type="text/css" />
    <link href="/css/rangeSlider.css" rel="stylesheet" type="text/css" />
    <link href="/css/main.css" rel="stylesheet" type="text/css" />
    <link href="/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="/css/common.css" rel="stylesheet" type="text/css" />



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body itemscope itemtype="http://schema.org/WebPage">
<?php $this->beginBody() ?>



<!-- HEADER BEGINS -->

<header id="header">
    <div class="first">
        <div>
            <div class="info">
                <span><?= Yii::t('app', 'Azerbaijan\'s Fastest Online Shopping Destination'); ?></span>
            </div>
            <div class="currency">
                <a href="#" class="azn"><?= Yii::$app->currency->userCurrency->code; ?></a>
                <ul>
                    <?php foreach (Yii::$app->currency->currencies as $currency) {
                        if ($currency == Yii::$app->currency->userCurrency) {
                            continue;
                        } ?>
                        <li><a href="/currency/switch?id=<?= $currency->id; ?>" data-cur="<?= mb_strtolower($currency->code); ?>"><?= $currency->code; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="lang">
                <a href="#"><?= Language::getCurrent()->label; ?></a>
                <ul>
                    <?php echo \frontend\components\LanguageSwitcher::widget(['page' => @$this->params['page']]); ?>
                </ul>
            </div>
            <div class="links">
                <ul>
                    <li><a href="//sell.yarpaq.az"><?= Yii::t('app', 'Sell On Yarpaq'); ?></a></li>

                    <?php $help_center = \common\models\info\Info::findOne(4); ?>
                    <li><a href="<?= $help_center->url; ?>"><?= $help_center->title; ?></a></li>
                </ul>
            </div>
            <div class="phone">
                <a href="tel:+994 12 310 30 03">+994 12 310 30 03</a>
            </div>
        </div>
    </div>
    <div class="second">
        <div>
            <div>
                <a href="#" class="search_toggler"></a>
                <h1 class="logo"><a href="<?php echo \frontend\components\HomePageLink::widget(); ?>"></a></h1>
                <div class="nav_trigger">
                    <a href="#"><?= Yii::t('app', 'Categories'); ?><span></span></a>
                    <div class="full_nav">
                        <div class="left_side">
                            <?php
                            $topCategoryList = TopCategoryList::getCategories()->all();
                            $main_categories = Category::find()->andWhere(['depth' => 2])->orderBy('lft')->all();

                            if (count($topCategoryList)) {
                            ?>
                            <div class="top_categories">

                                <h2><?= Yii::t('app', 'Top Categories'); ?><span></span></h2>
                                <ul>
                                    <?php foreach ($topCategoryList as $category) { ?>
                                        <li>
                                            <a href="<?= $category->url; ?>">
                                                <img src="/category_icons/<?= $category->id; ?>.png" alt="<?= $category->title; ?>"><?= $category->title; ?>
                                            </a>

                                            <div>
                                                <nav>

                                                    <div> <!-- Column -->

                                                        <?php
                                                        foreach ($category->getChildren()->all() as $subcategory) { ?>
                                                            <article>
                                                                <h3><a href="<?= $subcategory->url; ?>"><?= $subcategory->title; ?></a></h3>
                                                                <ul>
                                                                    <?php foreach ($subcategory->getChildren()->all() as $subsubcategory) {?>
                                                                        <li><a href="<?= $subsubcategory->url; ?>"><?= $subsubcategory->title; ?></a></li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </article>
                                                        <?php } ?>
                                                    </div>

                                                </nav>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                            <div class="categories_list">
                                <ul>
                                    <?php foreach ($main_categories as $category) { ?>
                                    <li>
                                        <a href="<?= $category->url; ?>"><?= $category->title; ?></a>
                                        <div>
                                            <nav>

                                                <div> <!-- Column -->

                                                    <?php
                                                    foreach ($category->getChildren()->all() as $subcategory) { ?>
                                                    <article>
                                                        <h3><a href="<?= $subcategory->url; ?>"><?= $subcategory->title; ?></a></h3>
                                                        <ul>
                                                            <?php foreach ($subcategory->getChildren()->all() as $subsubcategory) {?>
                                                            <li><a href="<?= $subsubcategory->url; ?>"><?= $subsubcategory->title; ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </article>
                                                    <?php } ?>
                                                </div>

                                            </nav>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="right_side">
                            <nav></nav>
                            <div class="nav_banners">
                                <ul>
                                    <li><a href="#"><img src="/upload/Images/40.jpg" alt=""></a></li>
                                    <li><a href="#"><img src="/upload/Images/41.jpg" alt=""></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="head_search">
                    <form action="<?= Language::getCurrent()->urlPrefix . '/search'; ?>" method="get">
                        <input type="text"
                               placeholder="<?= Yii::t('app', 'Enter product name'); ?>"
                               name="q" autocomplete="off"
                               value="<?= @htmlentities($this->params['q']); ?>">
                        <button type="submit"><?= Yii::t('app', 'Search'); ?></button>
                        <ul style="display: none">
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Mens fashion</a></li>
                            <li><a href="#">Corablar</a></li>
                            <li><a href="#">Kişi ayaqqabıları</a></li>
                            <li><a href="#">Sandal və tərliklər</a></li>
                        </ul>
                    </form>
                    <a href="#" class="close"><?= Yii::t('app', 'Cancel'); ?></a>
                    <div class="last_searched_list" style="display: none !important;">
                        <h3>Recently searches</h3>
                        <ul>
                            <li><a href="#">Mens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                        </ul>
                    </div>
                    <div class="tending_searches" style="display: none !important;">
                        <h3>Trendİng searches</h3>
                        <ul>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                        </ul>
                    </div>
                </div>
                <div class="sign_link">
                    <a href="#">
                        <span><?= Yii::$app->user->isGuest ? Yii::t('app', 'Sign in') : Yii::t('app', 'Account'); ?></span>
                    </a>
                    <div class="sign_in_dropdown">
                        <?php if (Yii::$app->user->isGuest) { ?>
                        <div>
                            <p><?= Yii::t('app', 'If you are a new user'); ?></p>
                            <div class="register">
                                <a href="<?= Url::toRoute(['/registration']); ?>"><?= Yii::t('app', 'Register'); ?></a>
                            </div>
                            <div class="login">
                                <a href="#"><?= Yii::t('app', 'Login'); ?></a>
                            </div>
                        </div>
                        <?php } else { ?>
                        <nav>
                            <p>t-moor@test.ru</p>
                            <ul>
                                <li><a href="<?= Url::to(['user/account']); ?>" class="account"><?= Yii::t('app', 'My account'); ?></a></li>
                                <li><a href="<?= Url::to(['user/orders-history']); ?>" class="orders"><?= Yii::t('app', 'Orders history'); ?></a></li>
                                <li style="display: none;"><a href="#" class="wishlist">Wishlist</a></li>
                            </ul>
                        </nav>
                        <div>
                            <div class="logout">
                                <a href="<?= Url::toRoute(['/logout']); ?>"><?= Yii::t('app', 'Logout'); ?></a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="basket_link">
                    <a href="<?= Url::to(['cart/index']) ?>"><?= Yii::t('app', 'Cart'); ?></a>
                </div>
            </div>
        </div>
    </div>
</header>

<a href="#" class="toggler"><em></em><em></em><em></em></a>

<!-- HEADER END -->

<div class="main_wrapper">

    <main>
        <?= $content ?>
    </main>

    <?= $this->render('_footer'); ?>

</div>


<!-- MODALS BEGIN -->

<div class="darkness"></div>

<div class="darkness_nav"></div>

<div class="signin_modal">
    <div class="sign_back">
        <ul>
            <li><img src="/img/icon_10.svg" alt=""><span><?= Yii::t('app', 'SƏRFƏLİ QİYMƏTLƏR'); ?></span></li>
            <li><img src="/img/icon_11.svg" alt=""><span><?= Yii::t('app', 'GÜVƏNİLİR ALIŞ-VERİŞ'); ?></span></li>
            <li><img src="/img/icon_12.svg" alt=""><span><?= Yii::t('app', '100% QAYTARILMA'); ?></span></li>
            <li><img src="/img/icon_13.svg" alt=""><span><?= Yii::t('app', 'RAHAT ÖDƏNİŞ'); ?></span></li>
            <li><img src="/img/icon_14.svg" alt=""><span><?= Yii::t('app', 'PULSUZ ÇATDIRILMA'); ?></span></li>
        </ul>
    </div>
    <div>
        <header>
            <h2>Login On Yarpaq.az</h2>
            <p>Please provide your Email to Login</p>
            <a href="#" class="close"></a>
        </header>
        <div class="form">
            <form action="/user/login" id="signin-popup-form">
                <ul>
                    <li><input type="text" name="LoginForm[email]" placeholder="<?= Yii::t('app', 'Email'); ?>"></li>
                    <li><input type="password" name="LoginForm[password]" placeholder="<?= Yii::t('app', 'Password'); ?>"></li>
                    <li><button type="submit"><?= Yii::t('app', 'Login'); ?></button></li>
                </ul>
            </form>
        </div>
        <div class="social_login" style="display: none;">
            <p>or Login using</p>
            <ul>
                <li><a href="#"><img src="/img/facebook_login.png" alt=""></a></li>
                <li><a href="#"><img src="/img/google_login.png" alt=""></a></li>
            </ul>
        </div>
    </div>
</div>

<!-- MODALS END -->


<a href="#" class="back_to_top"></a>


<script type="text/javascript" src="/js/jquery-latest.js"></script>
<script type="text/javascript" src="/js/jquery.mobile.custom.min.js"></script>
<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/product-filter.js"></script>
<script type="text/javascript" src="/js/checkout.js"></script>
<script type="text/javascript" src="/js/basket.js"></script>
<script type="text/javascript" src="/js/common.js"></script>


</body>
</html>