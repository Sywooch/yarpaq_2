<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use common\models\User;
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Y</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li>
                    <?php echo \backend\components\LanguageSwitcher::widget(); ?>
                </li>

                <?php if (User::hasPermission('view_common_notifications_for_admin')) { ?>
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown notifications-menu" id="commonNotificationsBlock" data-url="<?= \yii\helpers\Url::to(['notification/common-for-admin']); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning" id="noti_total"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <li>
                                    <a href="<?= Url::to(['product/index', 'ProductSearch[moderated]' => 0]); ?>">
                                        <i class="fa fa-users text-aqua"></i> <span id="noti_moderation_products"></span> <?= Yii::t('app', 'Moderation products'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['order/index', 'OrderSearch[order_status_id]' => 0]); ?>">
                                        <i class="fa fa-shopping-cart text-green"></i> <span id="noti_new_orders"></span> <?= Yii::t('app', 'New orders');?>
                                    </a>
                                </li>

                                <li style="display: none">
                                    <a href="#">
                                        <i class="fa fa-commenting text-yellow"></i> <span id="noti_reviews"></span> <?= Yii::t('app', 'New reviews');?>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= Url::to(['product/index', 'ProductSearch[quantity]' => 0]); ?>">
                                        <i class="fa fa-remove text-red"></i> <span id="noti_out_of_stock"></span> <?= Yii::t('app', 'Out of stock products');?>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?php echo Yii::$app->user->identity->profile->firstname.' '.Yii::$app->user->identity->profile->lastname; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p>
                                <?php echo Yii::$app->user->identity->profile->firstname.' '.Yii::$app->user->identity->profile->lastname; ?>
                                <small><?php echo Yii::$app->user->identity->email; ?></small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <?php if (false) { ?>
                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>
