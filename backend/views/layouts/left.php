<?php
use webvimark\modules\UserManagement\UserManagementModule;
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
                    ['label' => 'Products', 'url' => ['/product']],
                    ['label' => 'Categories', 'icon' => 'fa fa-sitemap', 'url' => ['/category']],
                    ['label' => 'Manufacturers', 'icon' => 'fa fa-tags', 'url' => ['/manufacturer']],
                    ['label' => 'Currencies', 'icon' => 'fa fa-money', 'url' => ['/currency']],
                    ['label' => 'Languages', 'icon' => 'fa fa-language', 'url' => ['/language']],
                    ['label' => 'Users', 'icon' => 'fa fa-users', 'url' => ['#'], 'items' => [
                        ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['/user-management/user/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Roles'), 'url' => ['/user-management/role/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Permissions'), 'url' => ['/user-management/permission/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Permission groups'), 'url' => ['/user-management/auth-item-group/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Visit log'), 'url' => ['/user-management/user-visit-log/index'], 'icon' => 'fa fa-angle-double-right'],
                    ]],
                    ['label' => 'System', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
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
