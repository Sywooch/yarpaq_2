<?php
use webvimark\modules\UserManagement\UserManagementModule;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Manufacturers', 'icon' => 'fa fa-file-code-o', 'url' => ['/manufacturer']],
                    ['label' => 'Currencies', 'icon' => 'fa fa-file-code-o', 'url' => ['/currency']],
                    ['label' => 'Users', 'items' => [
                        ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['/user-management/user/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Roles'), 'url' => ['/user-management/role/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Permissions'), 'url' => ['/user-management/permission/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Permission groups'), 'url' => ['/user-management/auth-item-group/index'], 'icon' => 'fa fa-angle-double-right'],
                        ['label' => UserManagementModule::t('back', 'Visit log'), 'url' => ['/user-management/user-visit-log/index'], 'icon' => 'fa fa-angle-double-right'],
                    ]],
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
