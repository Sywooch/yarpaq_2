<?php

use common\models\category\Category;
use common\models\info\Info;
use common\models\Language;

$slide1Link = ( $slide1 = Category::findOne(940) )  ? $slide1->url : '#';
$slide2Link = ( $slide2 = Category::findOne(949) )  ? $slide2->url : '#';
$slide3Link = ( $slide3 = Info::findOne(5)       )  ? $slide3->url : '#';
$slide4Link = ( $slide4 = Category::findOne(792) )  ? $slide4->url : '#';
$slide5Link = ( $slide5 = Category::findOne(583) )  ? $slide5->url : '#';

$currentLangName = Language::getCurrent()->name;
?>

<!-- INDEX SLIDER BEGINS -->

<?php
$slides = [
    '/upload/slides/power-bank-'.$currentLangName.'.jpg' => $slide1Link,
    '/upload/slides/smartphone-'.$currentLangName.'.jpg' => $slide2Link,
    '/upload/slides/deliver-'   .$currentLangName.'.jpg' => $slide3Link,
    '/upload/slides/new-shoes-' .$currentLangName.'.jpg' => $slide4Link,
    '/upload/slides/watch-'     .$currentLangName.'.jpg' => $slide5Link,
];

$mainImgUrl = array_keys($slides)[0];
$mainLink = array_values($slides)[0];
?>

<div id="index_slider">
    <div class="image">
        <div>
            <a href="<?= $mainLink; ?>">
                <img src="<?= $mainImgUrl; ?>" alt="">
            </a>
        </div>
    </div>
    <div class="arrows">
        <a href="#" class="prev"></a>
        <a href="#" class="next"></a>
    </div>
    <div class="bullets">
        <?php $i=0; foreach ($slides as $imgUrl => $link) { $i++ ?>
            <a href="<?= $imgUrl; ?>" data-link="<?= $link; ?>" <?php if ($i==1) { echo ' class="active"'; } ?>></a>
        <?php } ?>
    </div>
</div>

<!-- INDEX SLIDER END -->

<div class="mobile_categories" style="display: none;">
    <ul>
        <li><a href="#"><img src="upload/Images/20.jpg" alt=""></a></li>
        <li><a href="#"><img src="upload/Images/21.jpg" alt=""></a></li>
        <li><a href="#"><img src="upload/Images/20.jpg" alt=""></a></li>
        <li><a href="#"><img src="upload/Images/21.jpg" alt=""></a></li>
        <li><a href="#"><img src="upload/Images/20.jpg" alt=""></a></li>
        <li><a href="#"><img src="upload/Images/21.jpg" alt=""></a></li>
    </ul>
</div>

<!-- TOP PRODUCTS BEGINS -->

<div class="top_products">
    <h2><?= Yii::t('app', 'Top 20 products'); ?></h2>
    <!-- Bestsellers Tape -->
    <?php echo \frontend\components\BestSellersTape::widget(); ?>
    <!-- Bestsellers Tape END -->
</div>

<!-- TOP PRODUCTS END -->


<!-- BANNER END -->

<div class="banner_long">
    <a href="<?= $slide1Link; ?>">
        <img src="/upload/Images/school.jpg" alt=""><img src="/upload/Images/mobile-school.jpg" alt="">
    </a>
</div>

<!-- BANNER END -->


<!-- LAST VIEWED END -->

<div class="last_viewed">
    <div>
        <h2><?= Yii::t('app', 'New products'); ?></h2>
        <!-- Bestsellers Tape -->
        <?php echo \frontend\components\NewTape::widget(); ?>
        <!-- Bestsellers Tape END -->
    </div>
</div>

<!-- LAST VIEWED END -->

<!-- New Tape -->
<?php //echo \frontend\components\NewTape::widget(); ?>
<!-- New Tape END -->



<?php if (!Yii::$app->user->isGuest) {
    //echo \frontend\components\RecentlyViewedTape::widget();
} ?>