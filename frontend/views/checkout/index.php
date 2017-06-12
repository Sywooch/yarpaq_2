<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30 no-padding-xs">

        <div class="container no-padding">
            <div class="row">

                <aside class="col-sm-4 col-md-3 hidden-xs ">

                    <div class="infoMenuBox light-gray_bg">
                        <div class="list-infoMenu">
                            <div class="v-padding-5">
                                <div class="title green sizex14"><span>Account</span></div>
                                <ul class="sub-infoMenu" style="display: block;">
                                    <li><a href="#">Personal information</a></li>
                                    <li><a href="#">Addresses</a></li>
                                    <li><a href="#">Orders history</a></li>
                                    <li><a href="#">Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="col-sm-8 col-md-9 inner-content">
                    <div class="row margin-right-0">
                        <div class="content-box-heading light-gray_bg ">
                            <h4><?= Yii::t('app', 'Checkout'); ?></h4>
                        </div>

                        <form action="<?= \yii\helpers\Url::toRoute(['checkout/confirm']); ?>" method="post">
                            <input type="hidden"
                                   name="<?= Yii::$app->request->csrfParam ?>"
                                   value="<?= Yii::$app->request->getCsrfToken()?>">
                            <div class="order-registration row">
                                <div class=" hmargin-30">

                                    <div class="col-md-8">
                                        <div class="col-md-6  col-sm-6 no-padding padding-xs-0 padding-sm-0">
                                            <div class="delivery-address">
                                                <h5 class="green dejavu-bold"><?= Yii::t('app', 'Shipping address'); ?></h5>
                                                <ul>
                                                    <li><?= $address->firstname; ?> <?= $address->lastname; ?><?= $address->company ? ' ('.$address->company.')' : ''; ?></li>
                                                    <li><?= $address->address_1; ?></li>
                                                    <li><?= $address->city; ?>, <?= $address->country->name; ?></li>
                                                    <li><?= $user->profile->phone1; ?></li>
                                                    <li class="hide"><a href="#" class="underline-link green"> > Catdırma ünvanı dəyiş < </a></li>
                                                </ul>
                                            </div>
                                            <div class="delivery-method">
                                                <h5 class="green dejavu-bold"><?= Yii::t('app', 'Shipping method'); ?></h5>
                                                <ul>
                                                    <li>
                                                        <input type="radio" class="radio" id="radio1" name="shipping_method" checked value="1">
                                                        <label for="radio1"><?= Yii::t('app', 'Courier'); ?></label>
                                                        <div class="tooltip_styled">
                                                            <span class="tooltip-item green hide">(?)</span>
                                                            <div class="tooltip-content">
                                                                <h4 class="dejavu-bold">Transport</h4>
                                                                <p>yalnız Bakıdaxılı və Bakıətrafı, 3 iş günü ərzində çatdırılma).
                                                                    Ödənişin dəyəri: Bakıdaxili - Ödənişsizdir, Bakıətrafı - 2AZN.</p>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    <li class="hide">
                                                        <input type="radio" class="radio" id="radio2"  name="shipping_method" value="2">
                                                        <label for="radio2"><?= Yii::t('app', 'Post'); ?></label>
                                                        <div class="tooltip_styled">
                                                            <span class="tooltip-item green hide">(?)</span>
                                                            <div class="tooltip-content">
                                                                <h4 class="dejavu-bold">Transport</h4>
                                                                <p>yalnız Bakıdaxılı və Bakıətrafı, 3 iş günü ərzində çatdırılma).
                                                                    Ödənişin dəyəri: Bakıdaxili - Ödənişsizdir, Bakıətrafı - 2AZN.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6  col-sm-6 padding-xs-0  padding-sm-0">
                                            <div class="payment-method">
                                                <h5 class="green dejavu-bold"><?= Yii::t('app', 'Payment method'); ?></h5>
                                                <ul>
                                                    <li>
                                                        <input type="radio" class="radio" id="radio3" name="payment_method" value="5">
                                                        <label for="radio3"><div class="payPal"></div></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" class="radio" id="radio4" name="payment_method" value="3">
                                                        <label for="radio4" style="margin-bottom: 2px"><?= Yii::t('app', 'Plastic card'); ?></label>

                                                        <ul class="list-inline payment-list">
                                                            <li>
                                                                <i class="card_type visa-icon" id="visaType"></i>
                                                            </li>
                                                            <li>
                                                                <i class="card_type masterCard-icon" id="masterCardType"></i>
                                                            </li>
                                                        </ul>
                                                        <input type="hidden" name="card_type" id="cardType" value="v">
                                                    </li>
                                                    <li>
                                                        <input id="radio5" type="radio" class="radio" name="payment_method" value="6">
                                                        <label for="radio5"><?= Yii::t('app', 'Cash'); ?></label>

                                                    </li>
                                                    <li>
                                                        <input id="radio6" type="radio" class="radio" name="payment_method" value="7">
                                                        <label for="radio6"><?= Yii::t('app', 'Post'); ?></label>
                                                    </li>
                                                    <li>
                                                        <input id="radio7" type="radio" class="radio" name="payment_method" value="2">
                                                        <label for="radio7"><?= Yii::t('app', 'Albali'); ?></label>

                                                        <div class="smallSelects inline-block">
                                                            <div class="select-month">
                                                                <select class="form-control" name="millikart_taksit">
                                                                    <option value="1">1 ay</option>
                                                                    <option value="3">3 ay</option>
                                                                    <option value="6">6 ay</option>
                                                                    <option value="9">9 ay</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <input id="radio8" type="radio" class="radio" name="payment_method" value="bolkart">
                                                        <label for="radio8"><?= Yii::t('app', 'Bolkart'); ?></label>

                                                        <div class="smallSelects inline-block">
                                                            <div class="select-month">
                                                                <select class="form-control" name="bolkarttaksit">
                                                                    <option value="1">1 ay</option>
                                                                    <option value="3">3 ay</option>
                                                                    <option value="6">6 ay</option>
                                                                    <option value="9">9 ay</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12 padding-xs-0 hide">
                                            <hr class="gray-hr">
                                            <div class="col-md-5 no-padding-xs">Kuponlar, Hədiyyə kartları</div>
                                            <div class="col-md-7 no-padding  no-padding-xs">
                                                <div class="fileform middle-upload-input">
                                                    <div class="fileformlabel"></div>
                                                    <div class="selectbutton">İSTİFADƏ ET</div>
                                                    <input name="upload" class="upload" onchange="getName(this.value);" type="file">
                                                </div>
                                                <p class="sizex10 v-padding-5 margin-0"><?= Yii::t('app', 'Active coupons'); ?>:</p>
                                                <p class="sizex10">
                                                    <span class="green">AZN YARPAQ YY555 </span>
                                                    kuponu - 10 AZN
                                                    <a href="#" class="green pull-right underline-text"> <?= Yii::t('app', 'remove coupon'); ?></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box-payMethods">
                                            <div class="box-payMethods2 text-center hide">
                                                <div class="dejavu-bold sizex10"><?= Yii::t('app', 'Payment method'); ?></div>
                                                <div class="payPal center-block"></div>
                                                <div class="dejavu-bold sizex10">name.surname@gmail.com</div>
                                            </div>
                                            <div class="v-margin-10">
                                                <div class="sizex10 green text-uppercase hide">AZN YARPAQ YY555 kuponu: -10 M</div>
                                                <div>
                                                    <span class="dejavu-bold sizex14"><?= Yii::t('app', 'Total'); ?>:</span>
                                                    <span class="dejavu-bold sizex24"><?= $cart->total; ?><b class="manatFont">M</b> </span>
                                                </div>
                                            </div>

                                            <button class="text-uppercase btn btn-green display-block"><?= Yii::t('app', 'Confirm and Pay'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>