<?php
$rootPath = realpath(__DIR__.'/..');

require($rootPath.'/vendor/autoload.php');
require($rootPath.'/src/config/env.php');

defined('YII_DEBUG') or define('YII_DEBUG', (boolean)getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));

require($rootPath.'/vendor/yiisoft/yii2/Yii.php');

if (file_exists($rootPath.'/tests/codeception/c3.php')) {
    define('C3_CODECOVERAGE_ERROR_LOG_FILE', '/app/runtime/c3_error.log'); //Optional (if not set the default c3 output dir will be used)
    define('C3_CODECEPTION_CONFIG_PATH', '/app'); //Optional (if not set the default c3 output dir will be used)
    require_once $rootPath.'/tests/codeception/c3.php';
}

$config = require($rootPath.'/src/config/main.php');
$application = new yii\web\Application($config);
$application->run();
