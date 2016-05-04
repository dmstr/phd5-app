<?php

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
