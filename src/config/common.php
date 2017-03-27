<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

// prepare application languages
$languages = explode(',', getenv('APP_LANGUAGES'));

// prepare asset bundle config
$bundles = [];
if (getenv('APP_ASSET_USE_BUNDLED')) {
    $bundles = include Yii::getAlias('@web/bundles').'/config.php';
}
if (getenv('APP_ASSET_DISABLE_BOOTSTRAP_BUNDLE')) {
    $bundles['yii\bootstrap\BootstrapAsset'] = [
        'css' => [],
    ];
}

// set redis connection
\Resque::setBackend(
    getenv('REDIS_PORT_6379_TCP_ADDR').':'.
    getenv('REDIS_PORT_6379_TCP_PORT')
);

// custom layout for user module (manage/admin)
Yii::$container->set(
    'dektrium\user\controllers\AdminController',
    [
        'layout' => '@backend/views/layouts/box',
    ]
);

// Basic configuration, used in web and console applications
return [
    'id' => 'app',
    'name' => getenv('APP_TITLE'),
    'language' => $languages[0],
    'basePath' => realpath(__DIR__.'/..'),
    'vendorPath' => '@app/../vendor',
    'runtimePath' => '@app/../runtime',
    // Bootstrapped modules are loaded in every request
    'bootstrap' => [
        'log',
        'redirects',
    ],
    'aliases' => [
        'backend' => '@vendor/dmstr/yii2-backend-module/src',
    ],
    'params' => [
        'adminEmail' => getenv('APP_ADMIN_EMAIL'),
        'context.menuItems' => [],
        'yii.migrations' => [
            getenv('APP_MIGRATION_LOOKUP'),
            '@yii/rbac/migrations',
            '@yii/web/migrations',
            '@dektrium/user/migrations',
            '@vendor/lajax/yii2-translate-manager/migrations',
            '@vendor/pheme/yii2-settings/migrations',
            '@vendor/dmstr/yii2-prototype-module/src/migrations',
            '@hrzg/widget/migrations',
            '@bedezign/yii2/audit/migrations',
        ],
    ],
    'components' => [
        'assetManager' => [
            'dirMode' => 0775,
            // Hashing for distributed systems
            'hashCallback' => YII_ENV_DEV ?
                null :
                function ($path) {
                    return YII_ENV.'-'.substr(hash('sha256', $path), 0, 8).'-'.APP_VERSION.'-'.\Yii::$app->cache->get('prototype.less.changed_at');
                },
            // Note: You need to bundle asset with `yii asset` for development/debugging
            'bundles' => $bundles,
            'basePath' => '@app/../web/assets',
        ],
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
            'defaultRoles' => ['Default'],
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => !YII_ENV_DEV,
        ],
        'fs' => [
            'class' => 'creocoder\flysystem\LocalFilesystem',
            'path' => '@app/runtime',
        ],
        'fsS3' => [
            'class' => 'creocoder\flysystem\AwsS3Filesystem',
            'key' => getenv('AMAZON_S3_BUCKET_PUBLIC_KEY'),
            'secret' => getenv('AMAZON_S3_BUCKET_SECRET_KEY'),
            'bucket' => getenv('AMAZON_S3_BUCKET_NAME'),
            'prefix' => getenv('APP_NAME').'/public',
            'region' => getenv('AMAZON_S3_BUCKET_REGION'),
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
                    'enableCaching' => !YII_ENV_DEV,
                ],
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stderr',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'replaceNewline' => ''
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'fileTransportPath' => '@runtime/mail',
            'enableSwiftMailerLogging' => true,
            'useFileTransport' => YII_ENV_TEST,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => getenv('APP_MAILER_HOST'),
                'username' => getenv('APP_MAILER_USERNAME'),
                'password' => getenv('APP_MAILER_PASSWORD'),
            ],
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings',
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
            'enablePrettyUrl' => getenv('APP_PRETTY_URLS'),
            'showScriptName' => false,
            'enableDefaultLanguageUrlCode' => true,
            'baseUrl' => '/',
            'rules' => [],
            'ignoreLanguageUrlPatterns' => [
                // route pattern => url pattern
                '#^filefly/api#' => '#^filefly/api#',
            ],
            'languages' => $languages,
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'Tree' => '\dmstr\modules\pages\models\Tree',
                        'FA' => '\rmrevin\yii\fontawesome\FA',
                        'Url' => '\hrzg\filemanager\helpers\Url'
                    ],
                    'uses' => [
                        'yii\bootstrap',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'layout' => '@backend/views/layouts/box',
            'panels' => [
                'audit/request',
                'audit/mail' => [
                    'storeData' => false
                ],
                'audit/trail',
                'audit/javascript', # enable app.assets.registerJSLoggingAsset via settings
                // These provide special functionality and get loaded to activate it
                'audit/error',      // Links the extra error reporting functions (`exception()` and `errorMessage()`)
                'audit/extra',      // Links the data functions (`data()`)
                'audit/curl',       // Links the curl tracking function (`curlBegin()`, `curlEnd()` and `curlExec()`)
                //'audit/db',
                //'audit/log',
                //'audit/profiling',
            ],
            'ignoreActions' => [
                (getenv('APP_AUDIT_DISABLE_ALL_ACTIONS') ? '*':'_'),
                'audit/*',
                'help/*',
                'gii/*',
                'asset/*',
                'debug/*',
                'app/*',
                'resque/*',
                'db/create',
                'migrate/up',
            ],
            'maxAge' => 7,
        ],
        'backend' => [
            'class' => 'dmstr\modules\backend\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'filefly' => [
            'class' => 'hrzg\filefly\Module',
            'layout' => '@backend/views/layouts/main',
            'filesystem' => 'fsS3',
        ],
        'noty' => [
            'class' => 'lo\modules\noty\Module',
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
            'class' => 'dektrium\rbac\RbacWebModule',
            'layout' => '@backend/views/layouts/box',
            #'enableFlashMessages' => false,
        ],
        'redirects' => [
            'class' => 'dmstr\modules\redirect\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'resque' => [
            'class' => 'hrzg\resque\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'translatemanager' => [
            'class' => 'lajax\translatemanager\Module',
            'root' => '@app/views',
            'layout' => '@backend/views/layouts/box',
            'allowedIPs' => ['*'],
            'roles' => ['translate-module'],
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'layout' => '@app/views/layouts/container',
            'defaultRoute' => 'admin',
            'adminPermission' => 'user-module',
            'enableFlashMessages' => false,
        ],
        'widgets' => [
            'class' => 'hrzg\widget\Module',
            'layout' => '@backend/views/layouts/main',
        ],
    ],
];
