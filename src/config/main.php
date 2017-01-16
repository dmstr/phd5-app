<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace app\config;

use Yii;

// PHP Constants
$version = is_file(__DIR__.'/../version') ? trim(file_get_contents(__DIR__.'/../version')) : 'dev';
defined('APP_VERSION') or define('APP_VERSION', $version);
defined('APP_TYPE') or define('APP_TYPE', (php_sapi_name() == 'cli') ? 'console' : 'web');

// Define application aliases
Yii::setAlias('@app', realpath(__DIR__.'/..'));
Yii::setAlias('@root', '@app/..');
Yii::setAlias('@runtime', '@root/runtime');
Yii::setAlias('@web', '@root/web');
Yii::setAlias('@webroot', '@root/web');

// Use a closure to not pollute the global namespace
return call_user_func(function () {

    /*function checkFile(){
        if (file_exists($file)) {
            return $file;
        }
    }*/
    // Load $merge configuration files
    $configDir = __DIR__;
    $configFiles = [
        "{$configDir}/common.php" => true,
        "{$configDir}/".APP_TYPE.'.php' => true,
        "{$configDir}/common-".YII_ENV.'.php' => false,
        "{$configDir}/".APP_TYPE.'-'.YII_ENV.'.php' => false,
        "{$configDir}/".APP_TYPE.'-'.((YII_DEBUG)?'debug':'release').'.php' => false,
    ];

    if (!empty(getenv('APP_CONFIG_FILE'))) {
        $additionalConfigFiles = explode(',', getenv('APP_CONFIG_FILE'));
        // Merge additional configurations
        foreach ($additionalConfigFiles as $alias) {
            $file = Yii::getAlias($alias);
            $configFiles[$file] = true;
        }
    }

    // Merge configurations
    $config = [];
    //var_dump($configFiles);exit;
    Yii::trace($configFiles, __METHOD__);
    foreach ($configFiles as $file => $isRequired) {
        if (!is_file($file)) {
            if (!$isRequired) {
                continue;
            }
        }
        $config = \yii\helpers\ArrayHelper::merge(
            $config,
            require $file);
    }

    return $config;
});
