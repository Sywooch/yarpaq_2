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
    'name' => 'Yarpaq',
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
            'traceLevel' => 3,
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
                'cart/update'   => 'cart/update',
                'cart/remove'   => 'cart/remove',

                'info/<url:.+>' => 'info/index',

                '<controller:checkout>/<action:.+>' => '<controller>/<action>',

                'shipping/calculate'     => 'shipping/calculate',

                'rsearch'           => 'search/index',
                'search'            => 'search/elastic',
                'search/auto'       => 'search/auto',

                'currency/switch'        => 'currency/switch',



                'registration'              => 'user/registration',
                'login'                     => 'user/login',
                'password-recovery'         => 'user/recovery-password',
                'password-recovery-receive' => 'user/password-recovery-receive',
                'logout'                    => 'user-management/auth/logout',

                'user/profile'       => 'user/profile',
                'user/orders'        => 'user/orders',
                'user/success'       => 'user/success',

                'goldenpay_complete' => 'golden-pay-payment/callback',
                'millikart_callback' => 'albali-payment/callback',

                //'payment/<controller:.+>/<action:.+>' => '<controller>/<action>',

                'payment/albali-payment/<action:.+>'            => 'albali-payment/<action>',
                'payment/bolkart-payment/<action:.+>'           => 'bolkart-payment/<action>',
                'payment/cash-on-delivery-payment/<action:.+>'  => 'cash-on-delivery-payment/<action>',
                'payment/post-payment/<action:.+>'              => 'post-payment/<action>',
                'payment/golden-pay-payment/<action:.+>'        => 'golden-pay-payment/<action>',
                'payment/pay-pal-payment/<action:.+>'           => 'pay-pal-payment/<action>',


                '<controller:elastic>/<action:.+>' => 'elastic/<action>',
                '<controller:sitemap>/<action:.+>' => 'sitemap/<action>',
                //'<controller:elastic>/<action:.+>/<id:\d+>' => 'elastic/<action>',

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

            'mailerOptions' => [
                'from' => [
                    'support@yarpaq.az' => 'Yarpaq Support'
                ]
            ],

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
