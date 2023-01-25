<?php
// This is global bootstrap for autoloading

$rootPath = __DIR__.'/../..';

require($rootPath.'/vendor/autoload.php');
require($rootPath . '/config/env.php');

# TODO: review run webserver in YII_ENV=prod for acceptance tests, yii2-localurls has redirect issues in YII_ENV=test, see https://github.com/codemix/yii2-localeurls/issues/62
if (php_sapi_name() == 'cli' && getenv('YII_ENV') !== 'test') {
    echo "Error: YII_ENV must be set to 'test'\n";
    exit(1);
}

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_TEST_ENTRY_URL') or define('YII_TEST_ENTRY_URL', parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PATH));
defined('YII_TEST_ENTRY_FILE') or define('YII_TEST_ENTRY_FILE', realpath(__DIR__.'/../../web/index.php'));

require_once($rootPath.'/vendor/yiisoft/yii2/Yii.php');

$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] = parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_HOST);
$_SERVER['SERVER_PORT'] =  parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PORT) ?: '80';

Yii::setAlias('@tests', dirname(__DIR__));

\Codeception\Util\Fixtures::add('uniqid', uniqid('test'));
