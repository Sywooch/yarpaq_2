<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Baku',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'common\components\UserConfig',

            'on afterLogin' => function($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],

                'mail' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@common/messages',
                    'sourceLanguage'    => 'en'
                ],

                'modules/user-management/*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath'       => '@common/messages/webvimark',
                    'fileMap'        => [
                        'modules/user-management/back' => 'back.php',
                        'modules/user-management/front' => 'front.php',
                    ],
                ]
            ],
        ],
    ],
    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            'useEmailAsLogin' => true,

            'mailerOptions' => [
                'from' => [
                    'support@yarpaq.az' => 'Yarpaq Support'
                ],

                'registrationFormViewFile'     => '/common/mail/registrationEmailConfirmation',
                //'passwordRecoveryFormViewFile' => '/common/mail/passwordRecoveryMail',
                //'confirmEmailFormViewFile'     => '/common/mail/emailConfirmationMail',
            ],

            'on beforeAction' => function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = 'loginLayout.php';
                };
            }
        ]
    ],
];
