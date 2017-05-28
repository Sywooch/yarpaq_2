<?php
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Url;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/user-icon.png" class="img-circle" alt="User Image"/>
            </div>

            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->profile->firstname.' '.Yii::$app->user->identity->profile->lastname; ?></p>
                <span><?php echo Yii::$app->user->identity->email; ?></span>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Products', 'icon' => 'list', 'url' => ['/product']],
                    ['label' => 'Orders', 'icon' => 'shopping-cart', 'url' => ['/order']],
                    ['label' => 'Categories', 'icon' => 'sitemap', 'url' => ['/category']],
                    ['label' => 'Manufacturers', 'icon' => 'tags', 'url' => ['/manufacturer']],
                    ['label' => 'Currencies', 'icon' => 'money', 'url' => ['/currency']],
                    ['label' => 'Payment methods', 'url' => ['/payment-method']],
                    ['label' => 'Shipping methods', 'url' => ['/shipping-method']],
                    ['label' => 'Languages', 'icon' => 'language', 'url' => ['/language']],
                    ['label' => 'Users', 'icon' => 'users', 'url' => ['#'], 'items' => [
                        ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['/user-management/user/index'], 'icon' => 'angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Roles'), 'url' => ['/user-management/role/index'], 'icon' => 'angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Permissions'), 'url' => ['/user-management/permission/index'], 'icon' => 'angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Permission groups'), 'url' => ['/user-management/auth-item-group/index'], 'icon' => 'angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Visit log'), 'url' => ['/user-management/user-visit-log/index'], 'icon' => 'angle-double-right'],
                    ]],
                    ['label' => 'Base', 'items' => [
                        ['label' => 'Options', 'url' => ['option/index']]
                    ]],
                    ['label' => 'System', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => 'Same tools',
//                        'icon' => 'fa fa-share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'fa fa-circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'fa fa-circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
