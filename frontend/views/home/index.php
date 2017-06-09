<div class="widgets-content">

    <div class="overlap-content"></div>

    <!-- Slider -->
    <div id="home-slider">
        <div class="header-top-right">
            <div id="displayKSSlider" class="col-sm-12 homeslider-style2 no-padding">

                <!-- Module HomeSlider -->
                <div id="homepage-slider" class="homeslider">
                    <div class="content-slide">
                        <ul id="homeslider" class="contenhomeslider" style="max-height:337px;"
                            data-infiniteloop="0" data-auto="0"
                            data-speed="500" data-pause="3000" data-mode="horizontal"
                            data-usecss="0" data-minslide="1" data-maxslide="1"
                            data-hidecontrolonend="0" data-pager="1" data-autohover="1"
                            data-startslide="0" data-controls="1" data-slidemargin="0">

                            <li class="homeslider-container">
                                <div class="container" style="position:relative;">
                                    <a href="#">
                                        <img src="/img/front1.png" alt="">
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Module HomeSlider -->

            </div>
        </div>
    </div>
    <!-- Slider END -->
    <div class="clearfix"></div>


    <!-- New Tape -->
    <?php echo \frontend\components\NewTape::widget(); ?>
    <!-- New Tape END -->

    <!-- Bestsellers Tape -->
    <?php echo \frontend\components\BestSellersTape::widget(); ?>
    <!-- Bestsellers Tape END -->

    <?php if (!Yii::$app->user->isGuest) {
        echo \frontend\components\RecentlyViewedTape::widget();
    } ?>

</div>