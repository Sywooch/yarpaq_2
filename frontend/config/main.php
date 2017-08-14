<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'cart' => [
            'class' => 'frontend\components\Cart'
        ],
        'currency' => [
            'class' => 'frontend\components\Currency'
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'class' => 'frontend\components\LangRequest'
        ],
        'user' => [
            'class' => 'common\components\UserConfig',

            // Comment this if you don't want to record user logins
            'on afterLogin' => function($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'frontend\components\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'home/index',
                'product-<id:\d+>' => 'product/index',
                'seller-products-<id:\d+>' => 'seller-products/index',

                'cart'          => 'cart/index',
                'cart/add'      => 'cart/add',

                'info/<url:.+>' => 'info/index',

                '<controller:checkout>/<action:.+>' => '<controller>/<action>',
                'checkout/'      => 'checkout/index',

                'search'        => 'search/index',

                'currency/switch'        => 'currency/switch',

                'registration'  => 'user/registration',
                'login'         => 'user/login',
                'logout'        => 'user-management/auth/logout',
                'profile'       => 'user-management/user/profile',

                '<url:.+>'      => 'category/index'
            ],
        ],

        // используется для временной линковки картинок товаров,
        // после запуска можно уже переделать под общий лад
        'urlManagerProduct' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '//y2aa-frontend.dev/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            'useEmailAsLogin' => true,

            'on beforeAction' => function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            }
        ]
    ],
    'params' => $params,
];
