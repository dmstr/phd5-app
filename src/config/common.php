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
use lajax\translatemanager\services\scanners\ScannerJavaScriptFunction;
use lajax\translatemanager\services\scanners\ScannerPhpArray;
use lajax\translatemanager\services\scanners\ScannerPhpFunction;
use dmstr\lajax\translatemanager\services\scanners\ScannerDatabase;

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

$boxLayout = '@backend/views/layouts/box';

// custom layout for user module (manage/admin)
Yii::$container->set(
    Da\User\Controller\AdminController::class,
    [
        'layout' => $boxLayout,
    ]
);
Yii::$container->set(
    Da\User\Controller\PermissionController::class,
    [
        'layout' => $boxLayout,
    ]
);
Yii::$container->set(
    Da\User\Controller\RoleController::class,
    [
        'layout' => $boxLayout,
    ]
);
Yii::$container->set(
    Da\User\Controller\RuleController::class,
    [
        'layout' => $boxLayout,
    ]
);

// Basic configuration, used in web and console applications
return [
    'id' => 'app',
    'name' => getenv('APP_TITLE'),
    'language' => $languages[0],
    'basePath' => dirname(__DIR__),
    'vendorPath' => '@app/../vendor',
    'runtimePath' => '@app/../runtime',
    // Bootstrapped modules are loaded in every request
    'bootstrap' => [
        'log',
        'redirects',
        'queue',
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
        'backend.iframe.name' => getenv('APP_PARAMS_BACKEND_IFRAME_NAME') ?: '_self',
    ],
    'components' => [
        'assetManager' => [
            'dirMode' => 0775,
            'hashCallback' => getenv('APP_ASSET_FORCE_PUBLISH') ?
                \dmstr\helpers\AssetHash::byFileTime(!YII_DEBUG)
                : null,
            // Note: You need to bundle asset with `yii asset` for development/debugging
            'bundles' => $bundles,
            'basePath' => '@app/../web/assets/',
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
            'defaultRoles' => ['Default'],
            'cache' => 'cache'
        ],
        'cache' =>
            [
                'class' => getenv('APP_NO_CACHE') ?
                    \yii\caching\DummyCache::class : \yii\redis\Cache::class,
            ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => !getenv('APP_DB_DISABLE_SCHEMA_CACHE'),
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
            'traceLevel' => getenv('YII_TRACE_LEVEL') ?: 0,
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
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'as queuemanager' => \ignatenkovnikita\queuemanager\behaviors\QueueManagerBehavior::class
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
            'identityClass' => Da\User\Model\User::class,
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
                        'Markdown' => ['class' => \yii\helpers\Markdown::class],
                    ],
                    'functions' => [
                        'image' => function ($imageSource, $preset = null) {
                            // preset example, when using imageproxy, https://github.com/willnorris/imageproxy#examples
                            if (getenv('IMAGEPROXY_SIGNATURE_KEY')) {
                                $key = getenv('IMAGEPROXY_SIGNATURE_KEY');
                                $preset .= ',s' . strtr(
                                    base64_encode(hash_hmac('sha256', $imageSource, $key, 1)),
                                    '/+',
                                    '_-'
                                );
                            }
                            return Yii::$app->settings->get('imgBaseUrl', 'app.frontend') .
                                $preset .
                                Yii::$app->settings->get('imgHostPrefix', 'app.frontend') .
                                $imageSource .
                                Yii::$app->settings->get('imgHostSuffix', 'app.frontend');
                        },
                        't' => function ($category, $message) {
                            return Yii::t($category, $message);
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
            'layout' => $boxLayout,
            'panels' => [
                'audit/trail' => [
                    'class' => \bedezign\yii2\audit\panels\TrailPanel::class
                ],
                'audit/mail' => [
                    'class' => \bedezign\yii2\audit\panels\MailPanel::class
                ],
                // Links the extra error reporting functions (`exception()` and `errorMessage()`)
                'audit/error' => [
                    'class' => \bedezign\yii2\audit\panels\ErrorPanel::class
                ],
                // see https://github.com/bedezign/yii2-audit for detailed config
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
            'filesystemComponents' => [
                's3' => 'fsS3',
                'local' => 'fsLocal',
                'runtime' => 'fsRuntime',
            ],
        ],
        'noty' => [
            'class' => \lo\modules\noty\Module::class,
        ],
        'queuemanager' => [
            'class' => \ignatenkovnikita\queuemanager\QueueManager::class,
            'layout' => $boxLayout,
        ],
        'pages' => [
            'class' => \dmstr\modules\pages\Module::class,
            'layout' => '@backend/views/layouts/main',
        ],
        'prototype' => [
            'class' => \dmstr\modules\prototype\Module::class,
            'layout' => $boxLayout,
        ],
        'publication' => [
            'class' => dmstr\modules\publication\Module::class
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
            'layout' => $boxLayout,
            'root' => '@app/views',
            'tables' => [
                [
                    'connection' => 'db',
                    'table' => '{{%hrzg_widget_template}}',
                    'columns' => ['twig_template']
                ],
                [
                    'connection' => 'db',
                    'table' => '{{%twig}}',
                    'columns' => ['value']
                ]
            ],
            'scanners' => [
                ScannerPhpFunction::class,
                ScannerPhpArray::class,
                ScannerJavaScriptFunction::class,
                ScannerDatabase::class
            ],
            'allowedIPs' => ['*'],
            'roles' => ['translate-module'],
        ],
        'user' => [
            'class' => Da\User\Module::class,
            'layout' => '@app/views/layouts/container',
            'defaultRoute' => 'admin',
            'administratorPermissionName' => 'user-module',
            'administrators' => ['admin'],
            'enableFlashMessages' => false,
            'enableRegistration' => getenv('APP_USER_ENABLE_REGISTRATION'),
            'mailParams' => [
                'fromEmail' => getenv('APP_ADMIN_EMAIL')
            ],
        ],
        'widgets' => [
            'class' => \hrzg\widget\Module::class,
            'layout' => '@backend/views/layouts/main',
            'frontendRouteMap' => [
                'app/site/index' => '/',
                'pages/default/page' => 'pages/default/page',
            ],
        ],
    ],
];
