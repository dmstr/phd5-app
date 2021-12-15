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

// For functional and unit tests, also for app integration tests in projects
defined('APP_TYPE') or define('APP_TYPE', 'web');

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/main.php'),
    [
        'language' => 'en',
        'components' => [
            'request' => [
                'cookieValidationKey' => 'FUNCTIONAL_TESTING'
            ],
            'urlManager' => [
                'scriptUrl' => '',
                'enableDefaultLanguageUrlCode' => false,
            ],
            'user' => [
                'loginUrl' => '/user/login'
            ]
        ],
    ]
);
