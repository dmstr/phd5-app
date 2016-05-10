<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Basic configuration, used in web and console applications
return [
    'id' => 'app',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'vendorPath' => '@app/../vendor',
    'runtimePath' => '@app/../runtime',
    // Bootstrapped modules are loaded in every request
    'bootstrap' => [
        'log',
    ],
    'aliases' => [
        'backend' => '@vendor/dmstr/yii2-backend-module/src',
    ],
    'params' => [
        'adminEmail' => getenv('APP_ADMIN_EMAIL'),
        'yii.migrations' => [
            getenv('APP_MIGRATION_LOOKUP'),
            '@yii/rbac/migrations',
            '@dektrium/user/migrations',
            '@vendor/lajax/yii2-translate-manager/migrations',
            '@vendor/pheme/yii2-settings/migrations',
            '@vendor/dmstr/yii2-prototype-module/src/migrations',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => YII_ENV_PROD ? true : false,
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en',
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => YII_DEBUG ? false : true,
                ],
            ],
        ],
        'user' => [
            'class' => 'dmstr\web\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
            'identityClass' => 'dektrium\user\models\User',
            'rootUsers' => ['admin'],
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'enablePrettyUrl' => getenv('APP_PRETTY_URLS') ? true : false,
            'showScriptName' => getenv('YII_ENV_TEST') ? true : false,
            'enableDefaultLanguageUrlCode' => true,
            'baseUrl' => '/',
            'rules' => [],
            'languages' => explode(',', getenv('APP_LANGUAGES')),
        ],
    ],
    'modules' => [
        'backend' => [
            'class' => 'dmstr\modules\backend\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'pages' => [
            'class' => 'dmstr\modules\pages\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'prototype' => [
            'class' => 'dmstr\modules\prototype\Module',
            'layout' => '@backend/views/layouts/box',
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\Module',
            'layout' => '@backend/views/layouts/box',
            'enableFlashMessages' => false,
        ],
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Module',
            'root' => '@app/views',
            'layout' => '@backend/views/layouts/main',
            'allowedIPs' => ['*'],
            'roles' => ['translate-module'],
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'layout' => '@backend/views/layouts/box',
            'defaultRoute' => 'admin',
            'adminPermission' => 'user-module',
            'enableFlashMessages' => false,
        ],
    ]
];
