<?php

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // UserIdentity
        'user' => [
                 'class' => 'yii\web\User',
                'identityClass' => 'app\models\User',
        ],
        // Database
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=rbac',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ],
        'authManager' => [
                'class' => 'app\components\PhpManager',
                'defaultRoles' => ['guest'],
                
        ],
        /*'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/
    ],
    'params' => [],
];