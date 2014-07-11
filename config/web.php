<?php

return [
    'id' => 'app',
    // Preload the Debug Module
    'bootstrap' => [
        'debug','log'
    ],
    'basePath' => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    // Components
    'components' => [
        'request' => [
            'baseUrl' => '/',

        ],
        'urlManager' => [
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            
            'rules' => [

                    // Base
                    '' => 'site/index',
                    '<_a:(about|contact|error|captcha|state)>' => 'site/<_a>',
                    '<controller:\w+>/<id:\d+>'=>'<controller>/index',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ]
            
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        // Caching
        'cache' => [
                'class' => 'yii\caching\FileCache'
        ],
        // UserIdentity
        'user' => [
                'identityClass' => 'app\models\User',
        ],
        'authManager' => [
                'class' => 'app\components\PhpManager',
                'defaultRoles' => ['guest', 'admin', 'author'],
        ],
        // Logging
        'log' => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets' => [
                    [
                        'class' => 'yii\log\FileTarget',
                        'levels' => ['error', 'warning'],
                    ],
                ],
        ],
        // Database
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=rbac',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ]
    ],
    // Modules
    'modules' => [
        'debug' => 'yii\debug\Module',
        'gii' => 'yii\gii\Module'
    ],
    // Extra Params if we want them
    'params' => []
];
