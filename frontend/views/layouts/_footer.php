<?php
use common\models\info\Info;
?>
<!-- FOOTER BEGINS -->

<footer id="footer">
    <div class="quick_links">
        <ul>
            <li>
                <a href="#">
                    <span><img src="/img/icon_1.svg" alt=""></span>
                    <strong>SƏRFƏLİ QİYMƏTLƏR</strong>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><img src="/img/icon_2.svg" alt=""></span>
                    <strong>GÜVƏNİLİR ALIŞ-VERİŞ</strong>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><img src="/img/icon_3.svg" alt=""></span>
                    <strong>100% QAYTARILMA</strong>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><img src="/img/icon_4.svg" alt=""></span>
                    <strong>RAHAT ÖDƏNİŞ</strong>
                </a>
            </li>
            <li>
                <a href="#">
                    <span><img src="/img/icon_5.svg" alt=""></span>
                    <strong>PULSUZ ÇATDIRILMA</strong>
                </a>
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
                    <li><a href="<?= $pages[5]->url; ?>"><?= $pages[5]->title; ?></a></li>
                    <li><a href="<?= $pages[6]->url; ?>"><?= $pages[6]->title; ?></a></li>
                    <li><a href="<?= $pages[7]->url; ?>"><?= $pages[7]->title; ?></a></li>
                </ul>
            </article>
            <article>
                <h3>&nbsp;</h3>
                <ul>
                    <li><a href="<?= $pages[8]->url; ?>"><?= $pages[8]->title; ?></a></li>
                    <li><a href="<?= $pages[9]->url; ?>"><?= $pages[9]->title; ?></a></li>
                    <li><a href="<?= $pages[10]->url; ?>"><?= $pages[10]->title; ?></a></li>
                </ul>
            </article>
            <article>
                <h3><?= Yii::t('app', 'Account'); ?></h3>
                <ul>
                    <li><a href="#">Şəxsi məlumat</a></li>
                    <li><a href="#">Sifariş Tarixçəsi</a></li>
                    <li><a href="#">Ünvanlar</a></li>
                    <li><a href="#">Səbət</a></li>
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
                <img src="/img/credit_cards.png" alt="">
            </div>

        </div>
    </div>
    <div class="last_footer_mobile">
        <div class="first">
            <p><?= Yii::t('app', 'Sell on {yarpaq}', ['yarpaq' => 'yarpaq.az']); ?></p>
            <select name="" id="">
                <?php foreach (Yii::$app->currency->currencies as $currency) { ?>
                    <option value="<?= $currency->id; ?>"><?= $currency->code; ?></option>
                <?php } ?>
            </select>
            <select name="" id="">
                <option value="0">Azərbaycan</option>
                <option value="1">English</option>
                <option value="2">По русски</option>
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