<?php

use common\models\category\Category;
use common\models\info\Info;
use common\models\Language;
use common\models\slider\Slide;

$slide1Link = ( $slide1 = Category::findOne(940) )  ? $slide1->url : '#';
$slide2Link = ( $slide2 = Category::findOne(949) )  ? $slide2->url : '#';
$slide3Link = ( $slide3 = Info::findOne(5)       )  ? $slide3->url : '#';
$slide4Link = ( $slide4 = Category::findOne(792) )  ? $slide4->url : '#';
$slide5Link = ( $slide5 = Category::findOne(583) )  ? $slide5->url : '#';

$currentLangName = Language::getCurrent()->name;
?>

<!-- INDEX SLIDER BEGINS -->

<?php

$slides = Slide::find()
    ->andWhere(['status' => 1])
    ->orderBy('sort')
    ->all();

if (count($slides)) {

$mainSlide = $slides[0];
?>

<div id="index_slider">
    <div class="image">
        <div>
            <a href="<?= $mainSlide->content->link; ?>">
                <img src="<?= $mainSlide->content->url; ?>" alt="">
            </a>
        </div>
    </div>
    <div class="arrows">
        <a href="#" class="prev"></a>
        <a href="#" class="next"></a>
    </div>
    <div class="bullets">
        <?php $i=0; foreach ($slides as $slide) { $i++ ?>
            <a href="<?= $slide->content->url; ?>" data-link="<?= $slide->content->link; ?>" <?php if ($i==1) { echo ' class="active"'; } ?>></a>
        <?php } ?>
    </div>
</div>

<!-- INDEX SLIDER END -->

<?php } ?>

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