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
use dmstr\web\AdminLteAsset;
use hrzg\filefly\components\ImageUrlRule;
use yii\helpers\ArrayHelper;

$languages = explode(',', getenv('APP_LANGUAGES'));

// prepare asset bundle config
$bundles = [];
if (getenv('APP_ASSET_USE_BUNDLED')) {
    // include generated asset-bundle configuration
    $bundles = include Yii::getAlias('@web/bundles') . '/config.php';
    // disable loading of bundles skin file, when using bundled assets
    Yii::$container->set(
        AdminLteAsset::className(),
        [
            'skin' => false,
        ]
    );
}

// set redis connection
\Resque::setBackend(
    getenv('REDIS_PORT_6379_TCP_ADDR') . ':' .
    getenv('REDIS_PORT_6379_TCP_PORT')
);

// custom layout for user module (manage/admin)
Yii::$container->set(
    \dektrium\user\controllers\AdminController::class,
    [
        'layout' => '@backend/views/layouts/box',
    ]
);

// Basic configuration, used in web and console applications
return [
    'id' => 'app',
    'name' => getenv('APP_TITLE'),
    'language' => $languages[0],
    'basePath' => realpath(__DIR__ . '/..'),
    'vendorPath' => '@app/../vendor',
    'runtimePath' => '@app/../runtime',
    // Bootstrapped modules are loaded in every request
    'bootstrap' => [
        'log',
        'redirects',
    ],
    'aliases' => [
        'backend' => '@vendor/dmstr/yii2-backend-module/src',
        'storage' => '/mnt/storage',
        'bower' => '@vendor/bower',
        'npm' => '@vendor/npm',
    ],
    'params' => [
        'adminEmail' => getenv('APP_ADMIN_EMAIL'),
        'context.menuItems' => [],
        'backend.iframe.name' => 'backend-' . getenv('HOSTNAME'),
    ],
    'components' => [
        'assetManager' => [
            'dirMode' => 0775,
            'hashCallback' => getenv('APP_ASSET_FORCE_PUBLISH') ? \dmstr\helpers\AssetHash::byFileTimeAndLess() : null,
            // Note: You need to bundle asset with `yii asset` for development/debugging
            'bundles' => $bundles,
            'basePath' => '@app/../web/assets',
        ],
        'authManager' => [
            'class' => \dektrium\rbac\components\DbManager::class,
            'defaultRoles' => ['Default'],
        ],
        'cache' => getenv('APP_NO_CACHE') ? null : [
            'class' => \yii\redis\Cache::class,
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => !YII_ENV_DEV,
        ],
        'fsLocal' => [
            'class' => \creocoder\flysystem\LocalFilesystem::class,
            'path' => '@storage',
        ],
        'fsS3' => [
            'class' => \creocoder\flysystem\AwsS3Filesystem::class,
            'key' => getenv('AMAZON_S3_BUCKET_PUBLIC_KEY'),
            'secret' => getenv('AMAZON_S3_BUCKET_SECRET_KEY'),
            'bucket' => getenv('AMAZON_S3_BUCKET_NAME'),
            'prefix' => getenv('APP_NAME') . '/public',
            'region' => getenv('AMAZON_S3_BUCKET_REGION'),
        ],
        'fsRuntime' => [
            'class' => \creocoder\flysystem\LocalFilesystem::class,
            'path' => '@runtime',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => \yii\i18n\DbMessageSource::class,
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
                'common' => [
                    'class' => \codemix\streamlog\Target::class,
                    'url' => 'php://stderr',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'replaceNewline' => (APP_TYPE == 'console') ? null : '',
                ],
            ],
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'fileTransportPath' => '@runtime/mail',
            'enableSwiftMailerLogging' => true,
            'useFileTransport' => getenv('APP_MAILER_USE_FILE_TRANSPORT'),
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'host' => getenv('APP_MAILER_HOST'),
                'username' => getenv('APP_MAILER_USERNAME'),
                'password' => getenv('APP_MAILER_PASSWORD'),
            ],
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => 'redis',
        ],
        'session' => [
            'class' => \yii\web\DbSession::class
        ],
        'settings' => [
            'class' => \pheme\settings\components\Settings::class
        ],
        'user' => [
            'class' => \dmstr\web\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
            'identityClass' => \dektrium\user\models\User::class,
            'rootUsers' => ['admin'],
        ],
        'urlManager' => [
            'class' => \codemix\localeurls\UrlManager::class,
            'enablePrettyUrl' => getenv('APP_PRETTY_URLS'),
            'showScriptName' => false,
            'enableDefaultLanguageUrlCode' => true,
            'baseUrl' => '/',
            'rules' => [
                [
                    'class' => ImageUrlRule::class,
                    'suffix' => ',p',
                ],
            ],
            'ignoreLanguageUrlPatterns' => [
                // route pattern => url pattern
                '#^img/stream#' => '#^img/stream#',
                '#^filefly/api#' => '#^filefly/api#',
            ],
            'languages' => $languages,
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => \yii\twig\ViewRenderer::class,
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'Html' => ['class' => \yii\helpers\Html::class],
                        'Json' => ['class' => \yii\helpers\Json::class],
                        'Tree' => ['class' => \dmstr\modules\pages\models\Tree::class],
                        'FA' => ['class' => \rmrevin\yii\fontawesome\FA::class],
                        'FileUrl' => ['class' => \hrzg\filemanager\helpers\Url::class],
                        'Url' => ['class' => \yii\helpers\Url::class],
                    ],
                    'functions' => [
                        'image' => function ($imageSource, $preset = null) {
                            // preset example, when using imageproxy, https://github.com/willnorris/imageproxy#examples
                            return Yii::$app->settings->get('imgBaseUrl', 'app.frontend') .
                                $preset .
                                Yii::$app->settings->get('imgHostPrefix', 'app.frontend') .
                                $imageSource .
                                Yii::$app->settings->get('imgHostSuffix', 'app.frontend');
                        },
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
            'class' => \bedezign\yii2\audit\Audit::class,
            'accessRoles' => ['audit-module'],
            'layout' => '@backend/views/layouts/box',
            'panels' => [
                'audit/request',
                'audit/mail',
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
                (getenv('APP_AUDIT_DISABLE_ALL_ACTIONS') ? '*' : '_'),
                'app/*',
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
            'class' => \dmstr\modules\backend\Module::class,
            'layout' => '@backend/views/layouts/main',
            'modulesDashboardBlacklist' => [
                'noty',
                'treemanager',
            ],
        ],
        'contact' => [
            'class' => \dmstr\modules\contact\Module::class,
            'layout' => '@backend/views/layouts/main',
        ],
        'filefly' => [
            'class' => \hrzg\filefly\Module::class,
            'layout' => '@backend/views/layouts/main',
            'filesystem' => getenv('APP_FILEFLY_DEFAULT_FILESYSTEM'),
        ],
        'noty' => [
            'class' => \lo\modules\noty\Module::class,
        ],
        'pages' => [
            'class' => \dmstr\modules\pages\Module::class,
            'layout' => '@backend/views/layouts/main',
        ],
        'prototype' => [
            'class' => \dmstr\modules\prototype\Module::class,
            'layout' => '@backend/views/layouts/box',
        ],
        'publication' => [
            'class' => dmstr\modules\publication\Module::class
        ],
        'rbac' => [
            'class' => \dektrium\rbac\RbacWebModule::class,
            'layout' => '@backend/views/layouts/box',
            #'enableFlashMessages' => false,
        ],
        'redirects' => [
            'class' => \dmstr\modules\redirect\Module::class,
            'layout' => '@backend/views/layouts/main',
        ],
        'resque' => [
            'class' => \hrzg\resque\Module::class,
            'layout' => '@backend/views/layouts/main',
        ],
        'translatemanager' => [
            'class' => \lajax\translatemanager\Module::class,
            'root' => '@app/views',
            'layout' => '@backend/views/layouts/box',
            'allowedIPs' => ['*'],
            'roles' => ['translate-module'],
        ],
        'user' => [
            'class' => \dektrium\user\Module::class,
            'layout' => '@app/views/layouts/container',
            'defaultRoute' => 'admin',
            'adminPermission' => 'user-module',
            'admins' => ['admin'], // TODO: see https://github.com/dektrium/yii2-user/issues/1016
            'enableFlashMessages' => false,
            'enableRegistration' => getenv('APP_USER_ENABLE_REGISTRATION'),
        ],
        'widgets' => [
            'class' => \hrzg\widget\Module::class,
            'layout' => '@backend/views/layouts/main',
        ],
    ],
];
