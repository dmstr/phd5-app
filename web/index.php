<?php

// Prepare environment
$rootPath = realpath(__DIR__ . '/..');
require($rootPath . '/vendor/autoload.php');
require($rootPath . '/config/env.php');

// Enable YII_DEBUG by key/token cookie
if (strlen(getenv('APP_DEBUG_KEY') > 10) &&
    strlen(getenv('APP_DEBUG_TOKEN') > 10)) {
    if (isset($_COOKIE[getenv('APP_DEBUG_KEY')]) &&
        ($_COOKIE[getenv('APP_DEBUG_KEY')] === getenv('APP_DEBUG_TOKEN'))) {
        putenv('YII_DEBUG=1');
    }
}

// Define framework & application constants
defined('YII_DEBUG') or define('YII_DEBUG', (boolean)getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));
defined('APP_TYPE') or define('APP_TYPE', 'web');

// Load framework
require($rootPath . '/vendor/yiisoft/yii2/Yii.php');

// Codeception testing routes
if (YII_ENV_TEST && file_exists($rootPath . '/tests/c3.php')) {
    define(
        'C3_CODECOVERAGE_ERROR_LOG_FILE',
        getenv('C3_CODECOVERAGE_ERROR_LOG_FILE')); //Optional (if not set the default c3 output dir will be used)
    define(
        'C3_CODECEPTION_CONFIG_PATH',
        getenv('C3_CODECEPTION_CONFIG_PATH')); //Optional (if not set the default c3 output dir will be used)
    require_once $rootPath . '/tests/c3.php';
}

// Run application
(new yii\web\Application(require($rootPath . '/config/main.php')))->run();
