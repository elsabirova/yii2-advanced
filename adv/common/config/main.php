<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => \yii\i18n\Formatter::class,
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i'
        ],
        'taskService' => [
            'class' => \common\services\TaskService::class,
            'on ' . \common\services\TaskService::EVENT_AFTER_TAKE_TASK => function (\common\services\AfterTakeTaskEvent $e) {
                Yii::$app->notificationService->sendInfoAboutTakeTask($e->task, $e->project, $e->developer, $e->receivers);
            },
            'on ' . \common\services\TaskService::EVENT_AFTER_COMPLETE_TASK => function (\common\services\AfterCompleteTaskEvent $e) {
                Yii::$app->notificationService->sendInfoAboutCompleteTask($e->task, $e->project, $e->developer, $e->receivers);
            },
        ],
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            'on ' . \common\services\ProjectService::EVENT_ASSIGN_ROLE => function (\common\services\AssignRoleEvent $e) {
                Yii::$app->notificationService->sendInfoAboutNewRole($e->project, $e->user, $e->role);
            }
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class,
        ],
        'notificationService' => [
            'class' => \common\services\NotificationService::class,
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache'
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => yii\authclient\clients\Google::class,
                    'clientId' => '49068433203-uaem0r5m4iprjmn961ufs2svbs2m82sa.apps.googleusercontent.com',
                    'clientSecret' => '7P7Y8Z8mGGojyNYJKcEmMfJh',
                ],
                'facebook' => [
                    'class' => yii\authclient\clients\Facebook::class,
                    'clientId' => '405066390075438',
                    'clientSecret' => 'a2b9b13224e8a423eab2b75088423ba6',
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '6970697',
                    'clientSecret' => '3MJdjC4qpIkdebu4U6nh',
                    'scope' => ['email']
                ],
            ],
        ]
    ],
    'modules' => [
        'chat' => [
            'class' => common\modules\chat\Module::class,
        ],
        'comment' => [
            'class' => yii2mod\comments\Module::class,
        ],
    ],
];
