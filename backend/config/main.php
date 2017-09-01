<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Yarpaq',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'product/index',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'class'     => 'frontend\components\LangRequest'
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
//        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'class' => 'backend\components\MultiLangUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'user-management/auth/login',
                'logout' => 'user-management/auth/logout',
                'profile' => 'user-management/user/profile',
            ],
        ],

        'urlManagerUploads' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '//yarpaq.az/image/catalog/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],

        'urlManagerYarpaq' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '//yarpaq.az/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],

        // используется для временной линковки картинок товаров,
        // после запуска можно уже переделать под общий лад
        'urlManagerProduct' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '//yarpaq.az/image/catalog/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],

    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            'useEmailAsLogin' => true,

            'on beforeAction'=>function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            },



            'controllerMap' => [
                'user' => 'backend\controllers\UserController',
                'auth' => 'backend\controllers\AuthController'
            ],
            'viewPath' => '@backend/views/user-management',
        ]
    ],

    'params' => $params,
];
