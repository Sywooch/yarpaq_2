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
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
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
            'baseUrl' => '//y2aa-frontend.dev/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],

        'urlManagerYarpaq' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '//yarpaq.az/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],

    ],

    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',

            'on beforeAction'=>function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            },

            'controllerMap' => [
                'user' => 'backend\controllers\UserController'
            ],
            'viewPath' => '@backend/views/user-management',
        ]
    ],

    'params' => $params,
];
