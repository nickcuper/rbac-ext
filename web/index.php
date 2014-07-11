<?php

// Debug is on when remote address is localhost
defined('YII_DEBUG') or $_SERVER['REMOTE_ADDR'] === '127.0.0.1' and define('YII_DEBUG', true);
defined('YII_DEBUG') or $_SERVER['REMOTE_ADDR'] === '::1' and define('YII_DEBUG', true);
defined('YII_DEBUG') or define('YII_DEBUG', true);
define('YII_ENV_DEV', true);

ini_set('display_errors',         YII_DEBUG ? 1 : 0);
ini_set('display_startup_errors', YII_DEBUG ? 1 : 0);
error_reporting(YII_DEBUG ? -1 : 0);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);


(new yii\web\Application($config))->run();
