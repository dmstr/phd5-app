<?php

use bedezign\yii2\audit\Audit;
use bedezign\yii2\audit\panels\ErrorPanel;
use bedezign\yii2\audit\panels\ExtraDataPanel;
use bedezign\yii2\audit\panels\MailPanel;
use bedezign\yii2\audit\panels\TrailPanel;
use codemix\localeurls\UrlManager;
use codemix\streamlog\Target;
use creocoder\flysystem\AwsS3Filesystem;
use creocoder\flysystem\LocalFilesystem;
use Da\User\Component\AuthDbManagerComponent;
use Da\User\Controller\AdminController;
use Da\User\Controller\PermissionController;
use Da\User\Controller\RoleController;
use Da\User\Controller\RuleController;
use Da\User\Module as UserModule;
use dmstr\helpers\AssetHash;
use dmstr\lajax\translatemanager\services\scanners\ScannerDatabase;
use dmstr\modules\backend\Module as BackendModule;
use dmstr\modules\contact\Module as ContactModule;
use dmstr\modules\pages\models\Tree;
use dmstr\modules\pages\Module as PagesModule;
use dmstr\modules\prototype\Module as PrototypeModule;
use dmstr\modules\publication\Module as PublicationModule;
use dmstr\modules\redirect\Module as RedirectModule;
use dmstr\web\AdminLteAsset;
use dmstr\web\User;
use hrzg\filefly\components\ImageUrlRule;
use hrzg\filefly\Module as FileFlyModule;
use hrzg\resque\Module as ResqueModule;
use hrzg\widget\Module as WidgetsModule;
use ignatenkovnikita\queuemanager\behaviors\QueueManagerBehavior;
use ignatenkovnikita\queuemanager\QueueManager as QueueManagerModule;
use kartik\grid\Module as GridViewModule;
use lajax\translatemanager\Module as TranslatemanagerModule;
use lajax\translatemanager\services\scanners\ScannerJavaScriptFunction;
use lajax\translatemanager\services\scanners\ScannerPhpArray;
use lajax\translatemanager\services\scanners\ScannerPhpFunction;
use lo\modules\noty\Module as NotyModule;
use pheme\settings\components\Settings;
use rmrevin\yii\fontawesome\FA;
use yii\caching\DummyCache;
use yii\db\Connection;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\i18n\DbMessageSource;
use yii\queue\LogBehavior;
use yii\queue\redis\Queue;
use yii\redis\Cache;
use yii\swiftmailer\Mailer;
use yii\twig\ViewRenderer;
use yii\web\DbSession;
use yii\web\View;

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

// Basic configuration, used in web and console applications
return [
    'id' => 'app',
    'name' => getenv('APP_TITLE'),
    'language' => $languages[0],
    'basePath' => '@app',
    'vendorPath' => '@root/vendor',
    'runtimePath' => '@root/runtime',
    // Bootstrapped modules are loaded in every request
    'bootstrap' => [
        'log',
        'redirects',
        'queue'
    ],
    'aliases' => [
        'backend' => '@vendor/dmstr/yii2-backend-module/src',
        'storage' => '/mnt/storage',
        'bower' => '@vendor/bower-asset',
        'npm' => '@vendor/npm-asset'
    ],
    'params' => [
        'adminEmail' => getenv('APP_ADMIN_EMAIL'),
        'context.menuItems' => [],
        'backend.iframe.name' => getenv('APP_PARAMS_BACKEND_IFRAME_NAME') ?: '_self',
        'backend.browserSupport' => [
            'Chrome' => 87,
            'Edge' => false,
            'Safari' => false,
            'MobileSafari' => false,
            'Firefox' => 88,
            'Opera' => false,
            'Vivaldi' => false,
            'IE' => false
        ]
    ],
    'container' => [
        'definitions' => [
            AuthDbManagerComponent::class => [
                'defaultRoles' => ['Default'],
                'cache' => 'cache'
            ],
            AdminController::class => [
                'layout' => $boxLayout
            ],
            PermissionController::class => [
                'layout' => $boxLayout
            ],
            RoleController::class => [
                'layout' => $boxLayout
            ],
            RuleController::class => [
                'layout' => $boxLayout
            ]
        ]
    ],
    'components' => [
        'assetManager' => [
            'dirMode' => 0775,
            'hashCallback' => getenv('APP_ASSET_FORCE_PUBLISH') ? AssetHash::byFileTime(!YII_DEBUG) : null,
            // Note: You need to bundle asset with `yii asset` for development/debugging
            'bundles' => $bundles,
            'basePath' => '@app/../web/assets/'
        ],
        'cache' =>
            [
                'class' => getenv('APP_NO_CACHE') ?
                    DummyCache::class : Cache::class
            ],
        'db' => [
            'class' => Connection::class,
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => !getenv('APP_DB_DISABLE_SCHEMA_CACHE')
        ],
        'fsLocal' => [
            'class' => LocalFilesystem::class,
            'path' => '@storage'
        ],
        'fsS3' => [
            'class' => AwsS3Filesystem::class,
            'key' => getenv('AMAZON_S3_BUCKET_PUBLIC_KEY'),
            'secret' => getenv('AMAZON_S3_BUCKET_SECRET_KEY'),
            'bucket' => getenv('AMAZON_S3_BUCKET_NAME'),
            'prefix' => getenv('APP_NAME') . '/public',
            'region' => getenv('AMAZON_S3_BUCKET_REGION')
        ],
        'fsRuntime' => [
            'class' => LocalFilesystem::class,
            'path' => '@runtime'
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => DbMessageSource::class,
                    'db' => 'db',
                    'sourceLanguage' => 'en',
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 86400,
                    'enableCaching' => !YII_ENV_DEV
                ]
            ]
        ],
        'log' => [
            'traceLevel' => getenv('YII_TRACE_LEVEL') ?: 0,
            'targets' => [
                'common' => [
                    'class' => Target::class,
                    'url' => 'php://stderr',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'replaceNewline' => APP_TYPE === 'console' ? null : ''
                ]
            ]
        ],
        'mailer' => [
            'class' => Mailer::class,
            'fileTransportPath' => '@runtime/mail',
            'enableSwiftMailerLogging' => true,
            'useFileTransport' => getenv('APP_MAILER_USE_FILE_TRANSPORT'),
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'host' => getenv('APP_MAILER_HOST'),
                'port' => getenv('APP_MAILER_PORT'),
                'encryption' => getenv('APP_MAILER_ENCRYPTION'),
                'username' => getenv('APP_MAILER_USERNAME'),
                'password' => getenv('APP_MAILER_PASSWORD')
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'returnPath' => getenv('APP_MAILER_RETURN_PATH'),
                'from' => [getenv('APP_MAILER_FROM') => getenv('APP_TITLE')]
            ]
        ],
        'queue' => [
            'class' => Queue::class,
            'channel' => getenv('APP_QUEUE_CHANNEL'),
            'as log' => LogBehavior::class,
            'as queuemanager' => QueueManagerBehavior::class
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => getenv('REDIS_PORT_6379_TCP_ADDR'),
            'port' => getenv('REDIS_PORT_6379_TCP_PORT')
        ],
        'session' => [
            'class' => DbSession::class
        ],
        'settings' => [
            'class' => Settings::class
        ],
        'user' => [
            'class' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
            'identityClass' => Da\User\Model\User::class,
            'rootUsers' => ['admin']
        ],
        'urlManager' => [
            'class' => UrlManager::class,
            'enablePrettyUrl' => getenv('APP_PRETTY_URLS'),
            'showScriptName' => false,
            'enableDefaultLanguageUrlCode' => true,
            'baseUrl' => '/',
            'rules' => [
                [
                    'class' => ImageUrlRule::class,
                    'suffix' => ',p'
                ]
            ],
            'ignoreLanguageUrlPatterns' => [
                // route pattern => url pattern
                '#^img/stream#' => '#^img/stream#',
                '#^filefly/api#' => '#^filefly/api#'
            ],
            'languages' => $languages
        ],
        'view' => [
            'class' => View::class,
            'renderers' => [
                'twig' => [
                    'class' => ViewRenderer::class,
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true
                    ],
                    'globals' => [
                        'Html' => ['class' => Html::class],
                        'Json' => ['class' => Json::class],
                        'Tree' => ['class' => Tree::class],
                        'FA' => ['class' => FA::class],
                        'FileUrl' => ['class' => \hrzg\filemanager\helpers\Url::class],
                        'Url' => ['class' => Url::class],
                        'Markdown' => ['class' => Markdown::class]
                    ],
                    'functions' => [
                        'image' => function ($imageSource, $preset = null) {
                            // sanitize input
                            $preset = trim($preset, "/");
                            $baseUrl = trim(Yii::$app->settings->get('imgBaseUrl', 'app.frontend'), "/");
                            $prefix = trim(Yii::$app->settings->get('imgHostPrefix', 'app.frontend'), "/");
                            $imageSourceFull = $imageSource . Yii::$app->settings->get('imgHostSuffix', 'app.frontend');

                            // build remote URL
                            $remoteUrl = implode('/', array_filter([$prefix, $imageSourceFull]));

                            // add HMAC sign key to preset when using imageproxy, see also https://github.com/willnorris/imageproxy#examples
                            if (getenv('IMAGEPROXY_SIGNATURE_KEY')) {
                                $key = getenv('IMAGEPROXY_SIGNATURE_KEY');
                                $preset .= ',s' . strtr(
                                        base64_encode(hash_hmac('sha256', $remoteUrl, $key, 1)),
                                        '/+',
                                        '_-'
                                    );
                            }
                            return implode('/', array_filter([$baseUrl, $preset, $remoteUrl]));
                        },
                        't' => function ($category, $message, $params = [], $language = null) {
                            return Yii::t($category, $message, $params, $language);
                        }
                    ],
                    'uses' => [
                        'yii\bootstrap'
                    ]
                ]
            ]
        ]
    ],
    'modules' => [
        'audit' => [
            'class' => Audit::class,
            'accessRoles' => ['audit-module'],
            'layout' => $boxLayout,
            'panels' => [
                'audit/trail' => [
                    'class' => TrailPanel::class,
                    'maxAge' => null
                ],
                'audit/mail' => [
                    'class' => MailPanel::class,
                    'maxAge' => null
                ],
                // Links the extra error reporting functions (`exception()` and `errorMessage()`)
                'audit/error' => [
                    'class' => ErrorPanel::class,
                    'maxAge' => 30
                ],
                'audit/extra' => [
                    'class' => ExtraDataPanel::class,
                    'maxAge' => 30
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
                'resque/*',
                'db/create',
                'migrate/up'
            ],
            'maxAge' => 7
        ],
        'backend' => [
            'class' => BackendModule::class,
            'layout' => '@backend/views/layouts/main',
            'modulesDashboardBlacklist' => [
                'noty',
                'treemanager'
            ]
        ],
        'contact' => [
            'class' => ContactModule::class
        ],
        'filefly' => [
            'class' => FileFlyModule::class,
            'layout' => $boxLayout,
            'filesystem' => getenv('APP_FILEFLY_DEFAULT_FILESYSTEM'),
            'filesystemComponents' => [
                's3' => 'fsS3',
                'local' => 'fsLocal',
                'runtime' => 'fsRuntime'
            ]
        ],
        'gridview' => [
            'class' => GridViewModule::class
        ],
        'noty' => [
            'class' => NotyModule::class,
        ],
        'queuemanager' => [
            'class' => QueueManagerModule::class,
            'layout' => $boxLayout
        ],
        'pages' => [
            'class' => PagesModule::class,
            'layout' => $boxLayout
        ],
        'prototype' => [
            'class' => PrototypeModule::class,
            'layout' => $boxLayout
        ],
        'publication' => [
            'class' => PublicationModule::class
        ],
        'redirects' => [
            'class' => RedirectModule::class,
            'layout' => $boxLayout
        ],
        'resque' => [
            'class' => ResqueModule::class,
            'layout' => $boxLayout
        ],
        'translatemanager' => [
            'class' => TranslatemanagerModule::class,
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
            'roles' => ['translate-module']
        ],
        'user' => [
            'class' => UserModule::class,
            'layout' => '@app/views/layouts/container',
            'defaultRoute' => 'admin',
            'administratorPermissionName' => 'user-module',
            'administrators' => ['admin'],
            'enableFlashMessages' => false,
            'enableRegistration' => getenv('APP_USER_ENABLE_REGISTRATION'),
            'mailParams' => [
                'fromEmail' => getenv('APP_MAILER_FROM')
            ]
        ],
        'widgets' => [
            'class' => WidgetsModule::class,
            'layout' => $boxLayout,
            'frontendRouteMap' => [
                'app/site/index' => '/',
                'pages/default/page' => 'pages/default/page',
            ]
        ]
    ]
];
