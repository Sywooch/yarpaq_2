<?php

use common\models\Language;
use common\models\category\Category;
use yii\helpers\Html;

$main_categories = Category::find()->andWhere(['depth' => 2])->orderBy('lft')->all();

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
    <link href="/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="/css/rangeSlider.css" rel="stylesheet" type="text/css" />
    <link href="/css/main.css" rel="stylesheet" type="text/css" />
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
                <span>Azerbaijan's Fastest Online Shopping Destination</span>
            </div>
            <div class="currency">
                <a href="#" class="azn"><?= Yii::$app->currency->userCurrency->code; ?></a>
                <ul>
                    <?php foreach (Yii::$app->currency->currencies as $currency) {
                        if ($currency == Yii::$app->currency->userCurrency) {
                            continue;
                        } ?>
                        <li><a href="#" data-cur="<?= mb_strtolower($currency->code); ?>"><?= $currency->code; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="lang">
                <a href="#"><?= Language::getCurrent()->label; ?></a>
                <ul>
                    <?php foreach (Language::find()->all() as $language) {
                        if ($language == Language::getCurrent()) {
                            continue;
                        } ?>
                        <li><a href="<?= $language->urlPrefix; ?>/"><?= $language->label; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="links">
                <ul>
                    <li><a href="#">Sell On Yarpaq</a></li>
                    <li><a href="#">Help Center</a></li>
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
                            <div class="top_categories">
                                <h2><?= Yii::t('app', 'Top Categories'); ?><span></span></h2>
                                <ul>
                                    <li>
                                        <a href="#"><img src="/img/icon_10.png" alt="">Bütün təkliflər</a>
                                        <div>
                                            <nav>
                                                <div>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Womens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                </div>
                                            </nav>
                                        </div>
                                    </li>
                                    <li><a href="#"><img src="/img/icon_11.png" alt="">Telefonlar, Planşetlər</a></li>
                                    <li><a href="#"><img src="/img/icon_11.png" alt="">Elektronika</a></li>
                                </ul>
                            </div>
                            <div class="categories_list">
                                <ul>
                                    <?php foreach ($main_categories as $category) { ?>
                                    <li>
                                        <a href="<?= $category->url; ?>"><?= $category->title; ?></a>
                                        <div>
                                            <nav>
                                                <div>
                                                    <article>
                                                        <h3><a href="#"></a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Makasin</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Kişi ayaqqabıları</a></li>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Botlar</a></li>
                                                            <li><a href="#">Qaçış ayaqqabıları</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
                                                    <article>
                                                        <h3><a href="#">Mens Fashion</a></h3>
                                                        <ul>
                                                            <li><a href="#">Gündəlik</a></li>
                                                            <li><a href="#">Klassik</a></li>
                                                            <li><a href="#">İdman</a></li>
                                                            <li><a href="#">Sandal və tərliklər</a></li>
                                                            <li><a href="#">Corablar</a></li>
                                                            <li><a href="#">Hamısına Bax ></a></li>
                                                        </ul>
                                                    </article>
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
                        <button type="submit">Search</button>
                        <ul>
                            <li><a href="#">Womens fashion</a></li>
                            <li><a href="#">Mens fashion</a></li>
                            <li><a href="#">Corablar</a></li>
                            <li><a href="#">Kişi ayaqqabıları</a></li>
                            <li><a href="#">Sandal və tərliklər</a></li>
                        </ul>
                    </form>
                    <a href="#" class="close">Cancel</a>
                    <div class="last_searched_list">
                        <h3>Recently searches</h3>
                        <ul>
                            <li><a href="#">Mens fashion</a></li>
                            <li><a href="#">Womens fashion</a></li>
                        </ul>
                    </div>
                    <div class="tending_searches">
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
                    <a href="#"><span>Sign in</span></a>
                    <div class="sign_in_dropdown">
                        <nav>
                            <ul>
                                <li><a href="#" class="account">Your account</a></li>
                                <li><a href="#" class="orders">Your Orders</a></li>
                                <li><a href="#" class="wishlist">Wishlist</a></li>
                            </ul>
                            <p>Your text here</p>
                        </nav>
                        <div>
                            <p>If you are a new user</p>
                            <div class="register">
                                <a href="#">Register</a>
                            </div>
                            <div class="login">
                                <a href="#">LOGIN</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="basket_link"><a href="#">Cart<em>3</em></a></div>
            </div>
        </div>
    </div>
</header>

<a href="#" class="toggler"><em></em><em></em><em></em></a>

<!-- HEADER END -->

<div class="main_wrapper">

    <?= $content ?>

    <?= $this->render('_footer'); ?>

</div>


<!-- MODALS BEGIN -->

<div class="darkness"></div>

<div class="darkness_nav"></div>

<div class="signin_modal">
    <div class="sign_back">
        <ul>
            <li><img src="/img/icon_10.svg" alt=""><span>SƏRFƏLİ QİYMƏTLƏR</span></li>
            <li><img src="/img/icon_11.svg" alt=""><span>GÜVƏNİLİR ALIŞ-VERİŞ</span></li>
            <li><img src="/img/icon_12.svg" alt=""><span>100% QAYTARILMA</span></li>
            <li><img src="/img/icon_13.svg" alt=""><span>RAHAT ÖDƏNİŞ</span></li>
            <li><img src="/img/icon_14.svg" alt=""><span>PULSUZ ÇATDIRILMA</span></li>
        </ul>
    </div>
    <div>
        <header>
            <h2>Login/Sign Up On Yarpaq.az</h2>
            <p>Please provide your Mobile Number or Email to Login/ Sign Up on Snapdeal</p>
            <a href="#" class="close"></a>
        </header>
        <div class="form">
            <form action="simple.php">
                <ul>
                    <li><input type="text" placeholder="Name / Surname"></li>
                    <li><input type="text" placeholder="Email"></li>
                    <li><input type="password" placeholder="Password"></li>
                    <li><input type="password" placeholder="Re-enter password"></li>
                    <li><button type="submit">davam et</button></li>
                </ul>
            </form>
        </div>
        <div class="social_login">
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


</body>
</html>