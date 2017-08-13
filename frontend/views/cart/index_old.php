<div class="widgets-content">
    <div class="overlap-content"></div>
    <div class="v-padding-30 no-padding-xs">

        <div class="container no-padding">
            <div class="row">

                <aside class="col-sm-4 col-md-3 hidden-xs">
                    <div class="infoMenuBox light-gray_bg">
                        <div class="list-infoMenu">
                            <div class="v-padding-5">
                                <div class="title green sizex14"><span><?= Yii::t('app', 'Account'); ?></span></div>
                                <ul class="sub-infoMenu" style="display: block;">
                                    <li><a href="#"><?= Yii::t('app', 'Personal information'); ?></a></li>
                                    <li><a href="#"><?= Yii::t('app', 'Addresses'); ?></a></li>
                                    <li><a href="#"><?= Yii::t('app', 'Orders history'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="col-sm-8 col-md-9 inner-content">
                    <div class="row margin-right-0">
                        <div class="content-box-heading light-gray_bg clearfix">
                            <h4 class="pull-left"><?= Yii::t('app', 'Cart'); ?></h4>
                            <button class="pull-right btn btn-red hide"><?= Yii::t('app', 'Remove checked items'); ?></button>
                        </div>

                        <div class="cart-list basket-list row">
                            <div class="col-md-12">
                                <?php if ($cart->hasProducts()) { ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <!--<td width="30px"></td>-->
                                            <td><?= Yii::t('app', 'Product'); ?></td>
                                            <td width="103px"><?= Yii::t('app', 'Quantity');?></td>
                                            <td width="100px">1x <?= Yii::t('app', 'Price');?></td>
                                            <td><?= Yii::t('app', 'Total'); ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($cart->getProducts() as $key => $product) { ?>
                                        <tr>
                                            <!--
                                            <td valign="top" width="34px">

                                                <input id="radio<?= $product['product_id']; ?>" type="checkbox" class="radio square-radio"
                                                       name="method_payment"/>
                                                <label for="radio<?= $product['product_id']; ?>"></label>
                                            </td>
                                            -->
                                            <td class="description-backetProduct">
                                                <img src="<?= $product['image']; ?>" width="78" height="78">

                                                <div>
                                                    <div class="description-backetPr col-md-11 no-padding">
                                                        <?= $product['title']; ?>
                                                    </div>
                                                    <div class="description-backetPrColor hide">
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
                                <?php } else { ?>
                                    <p class="hmargin-30"><?= Yii::t('app', 'Your cart is empty'); ?></p>
                                <?php } ?>
                                <div class="hmargin-30">

                                    <?php if ($cart->hasProducts()) { ?>
                                    <div class="text-right size16 v-margin-15">
                                        <p class="margin-0"> <?= Yii::t('app', 'Subtotal'); ?>: <?= $cart->subTotal; ?> <b class="manatFont">M</b></p>

                                        <p class="green dejavu-bold margin-0"><?= Yii::t('app', 'Total'); ?>: <?= $cart->subTotal; ?> <b
                                                class="manatFont">M</b></p>
                                    </div>
                                    <?php } ?>
                                    <div>
                                        <a class="pull-left btn btn-white" href="<?= \yii\helpers\Url::previous(); ?>"><?= Yii::t('app', 'Continue shopping'); ?></a>
                                        <?php if ($cart->hasProducts()) { ?>
                                        <a href="<?= \yii\helpers\Url::toRoute('/checkout'); ?>" class="pull-right btn greenBg white"><?= Yii::t('app', 'Checkout'); ?></a>
                                        <?php } ?>
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