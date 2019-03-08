<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
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
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            'on ' . \common\services\ProjectService::EVENT_ASSIGN_ROLE => function(\common\services\AssignRoleEvent $e) {
                Yii::$app->notificationService->sendInfoAboutNewRole($e->project, $e->user, $e->role);
            }
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class,
        ],
        'notificationService' => [
            'class' => \common\services\NotificationService::class,
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => common\modules\chat\Module::class,
        ],
    ],
];
