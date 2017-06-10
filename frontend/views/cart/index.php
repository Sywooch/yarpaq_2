<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30">

        <div class="container no-padding">
            <div class="row">

                <aside class="col-sm-4 col-md-3 hidden-xs">
                    <div class="infoMenuBox light-gray_bg">
                        <div class="list-infoMenu">
                            <div class="v-padding-5">
                                <div class="title green sizex14"><span>Account</span></div>
                                <ul class="sub-infoMenu" style="display: block;">
                                    <li><a href="#">Personal information</a></li>
                                    <li><a href="#">Addresses</a></li>
                                    <li><a href="#">Orders history</a></li>
                                    <li class="active"><a href="#">Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="col-sm-8 col-md-9 inner-content">
                    <div class="row margin-right-0">
                        <div class="content-box-heading light-gray_bg clearfix">
                            <h4 class="pull-left"><?= Yii::t('app', 'Cart'); ?></h4>
                            <button class="pull-right btn btn-red "><?= Yii::t('app', 'Remove checked items'); ?></button>
                        </div>

                        <div class="cart-list basket-list row">
                            <div class="col-md-12">
                                <table>
                                    <thead>
                                        <tr>
                                            <td width="30px"><?= Yii::t('app', 'Check'); ?></td>
                                            <td><?= Yii::t('app', 'Product'); ?></td>
                                            <td width="103px"><?= Yii::t('app', 'Quantity');?></td>
                                            <td width="100px">1x <?= Yii::t('app', 'Price');?></td>
                                            <td><?= Yii::t('app', 'Total'); ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($cart->products as $key => $product) { ?>
                                        <tr>
                                            <td valign="top" width="34px">
                                                <input id="radio<?= $product['product_id']; ?>" type="checkbox" class="radio square-radio"
                                                       name="method_payment"/>
                                                <label for="radio7"></label>
                                            </td>
                                            <td class="description-backetProduct">
                                                <img src="<?= $product['image']; ?>" width="78" height="78">

                                                <div>
                                                    <div class="description-backetPr col-md-11 no-padding">
                                                        <?= $product['title']; ?>
                                                    </div>
                                                    <div class="description-backetPrColor">
                                                        Rəng: Qara
                                                    </div>

                                                    <div class="green sum-green"><?= Yii::t('app', 'Total'); ?>: <?= $product['total']; ?> <b class="manatFont">M</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td valign="top">
                                                <div class="quantity">
                                                    <div class="le-quantity">
                                                        <form>
                                                            <i class="sp-minus dejavu-bold">-</i>
                                                            <input class="quantity-input" name="quantity-input"
                                                                   readonly="readonly" type="text" value="<?= $product['quantity']; ?>"/>
                                                            <i class="sp-plus dejavu-bold">+</i>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td valign="top"><?= $product['price']; ?> <b class="manatFont">M</b></td>
                                            <td valign="top"><?= $product['total']; ?> <b class="manatFont">M</b></td>
                                            <td valign="bottom">
                                                <button class="btn cart-remove-btn ">x</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class=" hmargin-30">
                                    <div class=" vborder-gray v-padding-30">
                                        <div class="content-box-heading2 clearfix">
                                            <h4>Növbəti addımın nə olmasını istərdiniz?</h4>
                                        </div>

                                        <p class="light-gray">
                                            İstifadə etmək istədiyiniz endirim kodu ya da bonuslarınız varsa, və ya
                                            çatdırılma
                                            qiymətini dəyərləndirmək istəyirsinizsə, Seçin.
                                        </p>
                                        <ul class="border-list">
                                            <li>
                                                <div class="toggle-down">
                                                    Kupon Kodundan İstifadə Et
                                                    <i class="fa fa-angle-down pull-right"> </i>
                                                </div>
                                                <div class="angle-down-more margin-top-10" style="display: none">

                                                    <div class="fileform">
                                                        <div class="fileformlabel"></div>
                                                        <div class="selectbutton">KUPONDAN İSTİFADƏ ET</div>
                                                        <input type="file" name="upload" class="upload"
                                                               onchange="getName(this.value);"/>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="toggle-down">
                                                    Hədiyyə Çekindən İstifadə
                                                    <i class="fa fa-angle-down pull-right"> </i>
                                                </div>
                                                <div class="angle-down-more margin-top-10" style="display: none">

                                                    <div class="fileform">
                                                        <div class="fileformlabel"></div>
                                                        <div class="selectbutton">KUPONDAN İSTİFADƏ ET</div>
                                                        <input type="file" name="upload" class="upload"
                                                               onchange="getName(this.value);"/>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="toggle-down">
                                                    Çatdırılma Dəyəri & Vergilər
                                                    <i class="fa fa-angle-down pull-right"> </i>
                                                </div>
                                                <div class="angle-down-more margin-top-10" style="display: none">

                                                    <div class="fileform">
                                                        <div class="fileformlabel"></div>
                                                        <div class="selectbutton">KUPONDAN İSTİFADƏ ET</div>
                                                        <input type="file" name="upload" class="upload"
                                                               onchange="getName(this.value);"/>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="text-right size16 v-margin-15">
                                        <p class="margin-0"> Cəmi: 57.50 <b class="manatFont">M</b></p>

                                        <p class="green dejavu-bold margin-0">Yekun məbləğ: 57.50 <b
                                                class="manatFont">M</b></p>
                                    </div>
                                    <div>
                                        <button class="pull-left btn btn-white">ALIŞ-VERİŞİ DAVA ET</button>
                                        <button class="pull-right btn greenBg white">ÖDƏMƏYƏ KEÇ</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>