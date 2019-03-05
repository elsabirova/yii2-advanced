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
        ]
    ],
    'modules' => [
        'chat' => [
            'class' => common\modules\chat\Module::class,
        ],
    ],
];
