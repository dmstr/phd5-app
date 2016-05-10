<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Settings for web-application only
return [
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => getenv('APP_COOKIE_VALIDATION_KEY'),
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings',
        ],
    ],
    'modules' => [
        'settings' => [
            'class' => 'pheme\settings\Module',
            'layout' => '@backend/views/layouts/box',
            'accessRoles' => ['settings-module'],
        ],
    ]
];
