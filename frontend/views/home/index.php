<?php

use yii\helpers\Url;
use common\models\Language;
use common\models\slider\Slide;

$watches = \common\models\category\Category::findOne(577);
$slide1Link = $watches->url;

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


    <!-- DISCOUNT PRODUCTS BEGINS -->
    <div class="top_products">
        <h2><?= Yii::t('app', 'Discount products'); ?></h2>
        <?= \frontend\components\DiscountTape::widget(); ?>
    </div>
    <!-- DISCOUNT PRODUCTS ENDS -->


    <!-- BANNER END -->
    <?php
    $wide_banners = \common\models\wide_banner\WideBanner::find()->andWhere(['status' => 1])->all();

    foreach ($wide_banners as $wide_banner) { ?>
        <div class="banner_long">
            <a href="<?= $wide_banner->content->link != '' ? $wide_banner->content->link : '#'; ?>">
                <img src="<?= $wide_banner->content->url; ?>" alt=""><img src="<?= $wide_banner->content->mbUrl; ?>" alt="">
            </a>
        </div>
        <?php
    }
    ?>
    <!-- BANNER END -->


    <!-- TOP PRODUCTS BEGINS -->
    <?php //if ($this->beginCache('top-products-'.Yii::$app->language, ['duration' => 60 * 60 * 24])) { ?>
    <div class="top_products">
        <h2><?= Yii::t('app', 'Top 20 products'); ?></h2>
        <?= \frontend\components\BestSellersTape::widget(); ?>
    </div>
    <?php //$this->endCache(); } ?>
    <!-- TOP PRODUCTS END -->



    <!-- Promo Categories -->
    <?= \frontend\components\HomeCategoryGroup::widget(); ?>
    <!-- Promo Categories -->


    <!-- NEW PRODUCTS END -->
    <div class="last_viewed">
        <div>
            <h2><?= Yii::t('app', 'New products'); ?></h2>
            <?php echo \frontend\components\NewTape::widget(); ?>
        </div>
    </div>
    <!-- NEW PRODUCTS END -->


<?php if (!Yii::$app->user->isGuest) {
    //echo \frontend\components\RecentlyViewedTape::widget();
} ?>