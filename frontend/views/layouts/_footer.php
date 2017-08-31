<?php
use common\models\info\Info;
use yii\helpers\Url;
?>
<!-- FOOTER BEGINS -->

<footer id="footer">
    <div class="quick_links">
        <ul>
            <li>
                <span>
                    <span><img src="/img/icon_1.svg" alt=""></span>
                    <strong><?= Yii::t('app', 'Reasonable prices'); ?></strong>
                </span>
            </li>
            <li>
                <span>
                    <span><img src="/img/icon_2.svg" alt=""></span>
                    <strong><?= Yii::t('app', 'Safe shopping'); ?></strong>
                </span>
            </li>
            <li>
                <span>
                    <span><img src="/img/icon_3.svg" alt=""></span>
                    <strong><?= Yii::t('app', '100% return'); ?></strong>
                </span>
            </li>
            <li>
                <span>
                    <span><img src="/img/icon_4.svg" alt=""></span>
                    <strong><?= Yii::t('app', 'Convenient payment'); ?></strong>
                </span>
            </li>
            <li>
                <span>
                    <span><img src="/img/icon_5.svg" alt=""></span>
                    <strong><?= Yii::t('app', 'Free delivery'); ?></strong>
                </span>
            </li>
        </ul>
    </div>
    <div class="second_footer">
        <a href="#" class="up"><?= Yii::t('app', 'Back to top'); ?></a>
        <div>

            <?php
            $pages = [
                '5' => Info::findOne(5),
                '6' => Info::findOne(6),
                '7' => Info::findOne(7),
                '8' => Info::findOne(8),
                '9' => Info::findOne(9),
                '10' => Info::findOne(10),
            ];
            ?>
            <article>
                <h3><?= Yii::t('app', 'Information'); ?></h3>
                <ul>
                    <?php if ($pages[5]) { ?>
                    <li><a href="<?= $pages[5]->url; ?>"><?= $pages[5]->title; ?></a></li>
                    <?php } ?>

                    <?php if ($pages[6]) { ?>
                    <li><a href="<?= $pages[6]->url; ?>"><?= $pages[6]->title; ?></a></li>
                    <?php } ?>

                </ul>
            </article>
            <article>
                <h3>&nbsp;</h3>
                <ul>
                    <?php if ($pages[8]) { ?>
                    <li><a href="<?= $pages[8]->url; ?>"><?= $pages[8]->title; ?></a></li>
                    <?php } ?>

                    <?php if ($pages[9]) { ?>
                    <li><a href="<?= $pages[9]->url; ?>"><?= $pages[9]->title; ?></a></li>
                    <?php } ?>

                    <?php if ($pages[10]) { ?>
                    <li><a href="<?= $pages[10]->url; ?>"><?= $pages[10]->title; ?></a></li>
                    <?php } ?>
                </ul>
            </article>
            <article>
                <h3><?= Yii::t('app', 'Account'); ?></h3>
                <ul>
                    <li><a href="<?= Url::toRoute(['user/profile']); ?>"><?= Yii::t('app', 'My account'); ?></a></li>
                    <li><a href="<?= Url::toRoute(['user/orders']); ?>"><?= Yii::t('app', 'Orders history'); ?></a></li>
                    <li><a href="<?= Url::toRoute(['/cart']); ?>"><?= Yii::t('app', 'Cart'); ?></a></li>
                </ul>
            </article>
            <article>
                <h3><?= Yii::t('app', 'Contact us'); ?></h3>
                <ul>
                    <li><a href="tel:+994 12 310 30 03" class="phone">+994 12 310 30 03</a></li>
                    <li><a href="mailto:support@yarpaq.az" class="email">support@yarpaq.az</a></li>
                    <li><span>Yarpaq.az @ 2016-2017</span></li>
                </ul>
            </article>
            <article>
                <h3><?= Yii::t('app', 'Follow us'); ?></h3>
                <div class="social">
                    <a href="https://www.facebook.com/yarpaq.az/" target="_blank" class="facebook"></a>
                    <a href="https://www.instagram.com/yarpaq_az/" target="_blank" class="instagram"></a>
                </div>
            </article>
        </div>
    </div>
    <div class="last_footer">
        <div>
            <div class="left_side">
                <p><?= Yii::t('app', 'Payment'); ?></p>

                <div class="credit_cards">
                    <span><img src="/img/card_paypal.svg" alt="PayPal"></span>
                    <span><img src="/img/card_bolcard.svg" alt="Bolkart"></span>
                    <span><img src="/img/card_albali.svg" alt="Albalı"></span>
                    <span><img src="/img/card_master.svg" alt="MasterCard"></span>
                    <span><img src="/img/card_visa.svg" alt="Visa"></span>
                </div>

            </div>

        </div>
    </div>
    <div class="last_footer_mobile">
        <div class="first">
            <p>
                <a href="http://admin.yarpaq.az"><?= Yii::t('app', 'Sell on {yarpaq}', ['yarpaq' => 'yarpaq.az']); ?></a>
            </p>
            <select name="" id="footer-currency">
                <?php foreach (Yii::$app->currency->currencies as $currency) { ?>
                    <option <?php if ($currency->id == Yii::$app->currency->userCurrency->id) { echo 'selected'; } ?> value="<?= $currency->id; ?>"><?= $currency->code; ?></option>
                <?php } ?>
            </select>
            <select name="" id="footer-lang">
                <?php echo \frontend\components\LanguageSwitcher::widget(['page' => @$this->params['page'], 'select' => true]); ?>
            </select>
        </div>
        <div class="last">
            <?php
            $qayda = Info::findOne(9);
            $policy = Info::findOne(8);
            ?>
            <p><a href="<?= $qayda->url; ?>"><?= $qayda->title; ?></a> | <a href="<?= $policy->url; ?>"><?= $policy->title; ?></a></p>
            <p>2017 yarpaq.az | <?= Yii::t('app', 'All right reserved'); ?></p>
        </div>
    </div>
</footer>

<!-- FOOTER END -->