<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;
$_SERVER['HOST_NAME'] = 'web';

// TODO: Functional tests load CLI config by default, these are "web-overrides"
$applicationType = 'web';

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../src/config/main.php'),
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => 'FUNCTIONAL_TESTING'
            ],
            'urlManager' => [
                'enableDefaultLanguageUrlCode' => false,
            ]
        ]
    ]
);