<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$_SERVER['HOST_NAME'] = 'web';
$_SERVER['REQUEST_TIME'] = time();

// For functional and unit tests
defined('APP_TYPE') or define('APP_TYPE', 'web');

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../src/config/main.php'),
    [
        'language' => 'en',
        'components' => [
            'request' => [
                'cookieValidationKey' => 'FUNCTIONAL_TESTING'
            ],
            'urlManager' => [
                'scriptUrl' => '',
                'enableDefaultLanguageUrlCode' => false,
            ]
        ],
        'modules' => [
            // workaround for log dispatch issue, see also https://github.com/yiisoft/yii2-debug/issues/372
            'debug' => \yii\base\Module::class
        ]
    ]
);