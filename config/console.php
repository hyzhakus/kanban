<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'yoku-console',
    'name' => 'Kanban',
    'language' => 'uk_UA',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['orders'],
                    'logFile' => '@runtime/logs/orders.log',
                    'except' => ['application'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'i18n' => [
            'translations' => [
                'p*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'language' =>'uk-UA',
                ],
            ],
        ],
    ],
    'controllerMap' => [
       'migrate' => [
           'class' => 'yii\console\controllers\MigrateController',
           //'migrationPath' => null,
           'migrationNamespaces' => [
               // ...
               'yii\queue\db\migrations',
           ],
       ],
    ],
    'params' => $params,
];

return $config;
