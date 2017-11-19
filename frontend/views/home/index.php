<?php

use yii\helpers\Url;
use common\models\Language;
use common\models\slider\Slide;

$slide1Link = Url::to(['seller-products/index', 'id' => 67]);

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
    <div class="banner_long">
        <a href="<?= $slide1Link; ?>">
            <img src="/upload/Images/kreslo-puff.jpg" alt=""><img src="/upload/Images/kreslo-puff-mobile.jpg" alt="">
        </a>
    </div>
    <!-- BANNER END -->


    <!-- TOP PRODUCTS BEGINS -->
    <?php //if ($this->beginCache('top-products-'.Yii::$app->language, ['duration' => 60 * 60 * 24])) { ?>
    <div class="top_products">
        <h2><?= Yii::t('app', 'Top 20 products'); ?></h2>
        <?= \frontend\components\BestSellersTape::widget(); ?>
    </div>
    <?php //$this->endCache(); } ?>
    <!-- TOP PRODUCTS END -->



    <!-- NEW PRODUCTS END -->
    <div class="last_viewed">
        <div>
            <h2><?= Yii::t('app', 'New products'); ?></h2>
            <?php echo \frontend\components\NewTape::widget(); ?>
        </div>
    </div>
    <!-- NEW PRODUCTS END -->



    <!-- Promo Categories -->
    <?= \frontend\components\HomeCategoryGroup::widget(); ?>
    <!-- Promo Categories -->


<?php if (!Yii::$app->user->isGuest) {
    //echo \frontend\components\RecentlyViewedTape::widget();
} ?>