<!-- INDEX SLIDER BEGINS -->

<div id="index_slider">
    <div class="image">
        <div><a href="#!one"><img src="/upload/Images/deli.jpg" alt=""></a></div>
    </div>
    <div class="arrows">
        <a href="#" class="prev"></a>
        <a href="#" class="next"></a>
    </div>
    <div class="bullets">
        <a href="/upload/Images/watch.jpg" data-link="#!one" class="active"></a>
        <a href="/upload/Images/deli.jpg" data-link="#!two"></a>
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
    <a href="#"><img src="/upload/Images/school.jpg" alt=""><img src="/upload/Images/mobile-school.jpg" alt=""></a>
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