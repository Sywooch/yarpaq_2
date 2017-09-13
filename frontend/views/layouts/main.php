<?php

use common\models\Language;
use common\models\category\Category;
use common\models\category\TopCategoryList;
use yii\helpers\Url;

$this->beginPage();

$seo = $this->params['seo'];
?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="keywords" content="<?= $seo->keywords; ?>">
    <meta name="description" content="<?= $seo->description; ?>">

    <title><?= $seo->title; ?></title>

    <meta property="og:title" content="<?= $seo->title; ?>" />

    <?php if ($seo->type) { ?>
        <meta property="og:type" content="<?= $seo->type; ?>" />
    <?php } ?>

    <meta property="og:url" content="<?= $seo->url; ?>" />

    <?php if ($seo->image) { ?>
        <meta property="og:image" content="<?= $seo->image; ?>" />
    <?php } ?>

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="icon" type="image/png" href="/img/favicon.png"/>

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font/stylesheet.css" rel="stylesheet" type="text/css" />
    <link href="/css/rangeSlider.css" rel="stylesheet" type="text/css" />
    <link href="/js/zoom/dist/xzoom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/js/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/js/slick/slick-theme.css"/>
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
                    <li><a href="http://admin.yarpaq.az"><?= Yii::t('app', 'Sell On Yarpaq'); ?></a></li>

                    <?php $help_center = \common\models\info\Info::findOne(4); ?>
                    <li><a href="<?= @$help_center->url; ?>"><?= @$help_center->title; ?></a></li>
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
                            $main_categories = Category::find()
                                ->andWhere(['depth' => 2])
                                ->andWhere(['status' => Category::STATUS_ACTIVE])
                                ->andWhere(['isTop' => 0])
                                ->orderBy('lft')
                                ->all();

                            if (count($topCategoryList)) {
                            ?>
                            <div class="top_categories">

                                <h2><?= Yii::t('app', 'Top Categories'); ?><span></span></h2>
                                <ul>
                                    <?php foreach ($topCategoryList as $category) { ?>
                                        <li>
                                            <a href="<?= $category->url; ?>">
                                                <img width="40" src="<?= $category->icon->url; ?>" alt="<?= $category->title; ?>"><?= $category->title; ?>
                                            </a>

                                            <div>
                                                <nav>

                                                    <?php
                                                    $menu_cursor = 0;
                                                    foreach ($category->getChildren()->andWhere(['status' => Category::STATUS_ACTIVE])->all() as $subcategory) {
                                                        $menu_cursor++;

                                                        if (in_array($menu_cursor, [1,4,7])) { echo '<div>'; }
                                                        ?>
                                                        <article>
                                                            <h3><a href="<?= $subcategory->url; ?>"><?= $subcategory->title; ?></a></h3>
                                                            <ul>
                                                                <?php foreach ($subcategory->getChildren()->andWhere(['status' => Category::STATUS_ACTIVE])->all() as $subsubcategory) {?>
                                                                    <li><a href="<?= $subsubcategory->url; ?>"><?= $subsubcategory->title; ?></a></li>
                                                                <?php } ?>
                                                            </ul>
                                                        </article>

                                                        <?php
                                                        if (in_array($menu_cursor, [3,6,9])) { echo '</div>'; }
                                                    }
                                                    ?>

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

                                                <?php
                                                $menu_cursor = 0;
                                                foreach ($category->getChildren()->andWhere(['status' => Category::STATUS_ACTIVE])->all() as $subcategory) {
                                                    $menu_cursor++;

                                                    if (in_array($menu_cursor, [1,4,7])) { echo '<div>'; }
                                                    ?>
                                                    <article>
                                                        <h3><a href="<?= $subcategory->url; ?>"><?= $subcategory->title; ?></a></h3>
                                                        <ul>
                                                            <?php foreach ($subcategory->getChildren()->andWhere(['status' => Category::STATUS_ACTIVE])->all() as $subsubcategory) {?>
                                                            <li>
                                                                <a href="<?= $subsubcategory->url; ?>"><?= $subsubcategory->title; ?></a>

                                                                <ul>
                                                                    <?php foreach ($subsubcategory->getChildren()->andWhere(['status' => Category::STATUS_ACTIVE])->all() as $subsubsubcategory) {?>
                                                                        <li>
                                                                            <a href="<?= $subsubsubcategory->url; ?>"><?= $subsubsubcategory->title; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </article>

                                                <?php
                                                    if (in_array($menu_cursor, [3,6,9])) { echo '</div>'; }
                                                }
                                                ?>
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
                                    <li><a href="#"><img src="/upload/Images/mens.jpg" alt=""></a></li>
                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

                                </ul>
                                <ul>

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
                               id="main-search"
                               data-action="<?= Url::to(['search/auto']); ?>"
                               value="<?= @$this->params['q']; ?>">
                        <button type="submit"><?= Yii::t('app', 'Search'); ?></button>

                        <ul style="display: none;" class="autocomplete"></ul>
                    </form>
                    <a href="#" class="close"><?= Yii::t('app', 'Cancel'); ?></a>
                </div>
                <div class="sign_link">
                    <a href="javascript:void(0)">
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
                                <a href="#"><?= Yii::t('app', 'Sign in'); ?></a>
                            </div>
                        </div>
                        <?php } else { ?>
                        <nav>
                            <p><?= \common\models\User::getCurrentUser()->email; ?></p>
                            <ul>
                                <li><a href="<?= Url::toRoute(['user/profile']); ?>" class="account"><?= Yii::t('app', 'My account'); ?></a></li>
                                <li><a href="<?= Url::toRoute(['user/orders']); ?>" class="orders"><?= Yii::t('app', 'Orders history'); ?></a></li>
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
                    <a href="<?= Url::to(['cart/index']) ?>"><?= Yii::t('app', 'Cart'); ?><em><?= Yii::$app->cart->countProducts(); ?></em></a>
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
            <li><img src="/img/icon_10.svg" alt="<?= Yii::t('app', 'Reasonable prices'); ?>"><span><?= Yii::t('app', 'Reasonable prices'); ?></span></li>
            <li><img src="/img/icon_11.svg" alt="<?= Yii::t('app', 'Safe shopping'); ?>"><span><?= Yii::t('app', 'Safe shopping'); ?></span></li>
            <li><img src="/img/icon_12.svg" alt="<?= Yii::t('app', '100% return'); ?>"><span><?= Yii::t('app', '100% return'); ?></span></li>
            <li><img src="/img/icon_13.svg" alt="<?= Yii::t('app', 'Convenient payment'); ?>"><span><?= Yii::t('app', 'Convenient payment'); ?></span></li>
            <li><img src="/img/icon_14.svg" alt="<?= Yii::t('app', 'Free delivery'); ?>"><span><?= Yii::t('app', 'Free delivery'); ?></span></li>
        </ul>
    </div>
    <div>
        <header>
            <h2><?= Yii::t('app', 'Sign in'); ?></h2>
            <p><?= Yii::t('app', 'Please provide your Email and Password to Login'); ?></p>
            <a href="#" class="close"></a>
        </header>
        <div class="form">
            <form action="<?= Url::toRoute(['/user/login']); ?>" id="signin-popup-form">
                <ul>
                    <li><input type="text" name="LoginForm[email]" placeholder="<?= Yii::t('app', 'Email'); ?>"></li>
                    <li><input type="password" name="LoginForm[password]" placeholder="<?= Yii::t('app', 'Password'); ?>"></li>
                    <li>
                        <input type="checkbox" name="LoginForm[rememberMe]" value="1" id="signin_remember_me">
                        <label for="signin_remember_me"><?= Yii::t('app', 'Remember me'); ?></label>
                    </li>
                    <li>
                        <a href="<?= Url::to(['user/recovery-password']); ?>" id="forgot_password"><?= \webvimark\modules\UserManagement\UserManagementModule::t('front', 'Forgot password ?'); ?></a>
                    </li>
                    <li><button type="submit"><?= Yii::t('app', 'Sign in'); ?></button></li>
                </ul>
            </form>
        </div>
        <div class="social_login" style="display: none;">
            <p><?= Yii::t('app', 'or Login using'); ?></p>
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
<script type="text/javascript" src="/js/zoom/dist/xzoom.min.js"></script>
<script type="text/javascript" src="/js/slick/slick.min.js"></script>
<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/product-filter.js"></script>
<script type="text/javascript" src="/js/checkout.js"></script>
<script type="text/javascript" src="/js/basket.js"></script>
<script type="text/javascript" src="/js/common.js"></script>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'SdWZ5yalT3';
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/geo-widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->


<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] ||
        []).push(function() { try { w.yaCounter41194074 = new Ya.Metrika({
            id:41194074, clickmap:true, trackLinks:true,
            accurateTrackBounce:true }); } catch(e) { } }); var n =
            d.getElementsByTagName("script")[0], s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); }; s.type =
        "text/javascript"; s.async = true; s.src =
        "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else
    { f(); } })(document, window, "yandex_metrika_callbacks");
</script> <noscript><div><img
            src="https://mc.yandex.ru/watch/41194074" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-73707886-1', 'auto');
    ga('send', 'pageview');

</script>


</body>
</html>