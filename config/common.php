<?php

use app\helpers\ImageUrlHelper;
use bedezign\yii2\audit\Audit as AuditModule;
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
use Da\User\Controller\ProfileController;
use Da\User\Controller\RoleController;
use Da\User\Controller\RuleController;
use Da\User\Model\User as UserModel;
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
use dosamigos\translateable\TranslateableBehavior;
use hrzg\filefly\components\ImageUrlRule;
use hrzg\filefly\Module as FileFlyModule;
use hrzg\resque\Module as ResqueModule;
use hrzg\widget\Module as WidgetsModule;
use kartik\grid\Module as GridViewModule;
use lajax\translatemanager\Module as TranslatemanagerModule;
use lajax\translatemanager\services\scanners\ScannerJavaScriptFunction;
use lajax\translatemanager\services\scanners\ScannerPhpArray;
use lajax\translatemanager\services\scanners\ScannerPhpFunction;
use lo\modules\noty\Module as NotyModule;
use pheme\settings\components\Settings;
use rmrevin\yii\fontawesome\FA;
use yii\caching\ArrayCache;
use yii\caching\DummyCache;
use yii\db\Connection as DbConnection;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\i18n\DbMessageSource;
use yii\queue\db\Queue;
use yii\queue\ExecEvent;
use yii\queue\LogBehavior;
use yii\redis\Cache;
use yii\redis\Connection as RedisConnection;
use yii\redis\Mutex;
use yii\symfonymailer\Mailer;
use yii\twig\ViewRenderer;
use yii\web\Cookie;
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
        AdminLteAsset::class,
        [
            'skin' => false,
        ]
    );
}

// set convenience variables
$boxLayout = '@backend/views/layouts/box';
$isHttps = getenv('HTTPS') === 'on';
if (extension_loaded('pdo_mysql')) {
    $dbAttributes = [
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => 0
    ];
    if (getenv('MYSQL_ATTR_SSL_CA')) {
        $dbAttributes[PDO::MYSQL_ATTR_SSL_CA] = getenv('MYSQL_ATTR_SSL_CA');
    }
} else {
    $dbAttributes = [];
}

// Enable S3 component, if ENVs are set (BC)
$s3Enabled = class_exists('League\Flysystem\AwsS3v3\AwsS3Adapter') && getenv('AMAZON_S3_BUCKET_PUBLIC_KEY') && getenv('AMAZON_S3_BUCKET_SECRET_KEY') && getenv('AMAZON_S3_BUCKET_NAME') && getenv('AMAZON_S3_BUCKET_REGION');

// Default db translation config
$i18nTranslation = [
    'class' => DbMessageSource::class,
    'db' => 'db',
    'sourceLanguage' => 'xx-XX',
    'sourceMessageTable' => '{{%language_source}}',
    'messageTable' => '{{%language_translate}}',
    'cachingDuration' => 86400,
    'enableCaching' => !YII_ENV_DEV
];

$fallbackLanguage = getenv('APP_FALLBACK_LANGUAGE') ?: explode(',', getenv('APP_LANGUAGES'))[0];
$timezone = getenv('APP_TIMEZONE') ?: 'Europe/Berlin';
$locale = getenv('APP_LOCALE') ?: 'de-DE';

// Basic configuration, used in web and console applications
$common = [
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
            'Safari' => 14,
            'MobileSafari' => 14,
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
            ],
            Cookie::class => [
                'secure' => $isHttps
            ],
            ProfileController::class => [
                'as access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['show'],
                            // allow for all logged in users
                            #'roles' => ['@'],
                            // allow only if user has 'user' grant or requested his own profile (check by user->id)
                            'matchCallback' => function ($action) {
                                if (\Yii::$app->user->isGuest) {
                                    return false;
                                }
                                if (\Yii::$app->user->can('user')) {
                                    return true;
                                }
                                if (\Yii::$app->user->id === (int)Yii::$app->request->getQueryParam('id')) {
                                    return true;
                                }
                                return false;
                            }
                        ],
                    ],
                ],
            ],
            TranslateableBehavior::class => [
                'fallbackLanguage' => $fallbackLanguage
            ]
        ]
    ],
    'components' => [
        'assetManager' => [
            'dirMode' => 0775,
            'hashCallback' => getenv('APP_ASSET_FORCE_PUBLISH') ? AssetHash::byFileTime(!YII_DEBUG) : null,
            // Note: You need to bundle asset with `yii asset` for development/debugging
            'bundles' => $bundles,
            'basePath' => '@app/../web/assets/',
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'less' => ['css', 'nodepkg-linuxstatic lessc {from} {to} --no-color --source-map'],
                ],
            ],
        ],
        'cache' => [
            'class' => getenv('APP_NO_CACHE') ? DummyCache::class : Cache::class
        ],
        'cacheSystem' => [
            'class' => ArrayCache::class
        ],
        'db' => [
            'class' => DbConnection::class,
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8mb4',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => !getenv('APP_DB_DISABLE_SCHEMA_CACHE'),
            'attributes' => $dbAttributes
        ],
        'dbSystem' => [
            'class' => DbConnection::class,
            'dsn' => getenv('DATABASE_DSN'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'charset' => 'utf8mb4',
            'tablePrefix' => getenv('DATABASE_TABLE_PREFIX'),
            'enableSchemaCache' => true,
            'schemaCache' => 'cacheSystem',
            'attributes' => $dbAttributes
        ],
        'formatter' => [
            'locale' => $locale,
            'defaultTimeZone' => $timezone
        ],
        'fsLocal' => [
            'class' => LocalFilesystem::class,
            'path' => '@storage'
        ],
        'fsRuntime' => [
            'class' => LocalFilesystem::class,
            'path' => '@runtime'
        ],
        'fsFtp' => [
            'class' => \creocoder\flysystem\FtpFilesystem::class,
            'host' => getenv('FTP_BUCKET_HOST'),
            'port' => getenv('FTP_BUCKET_PORT') ?: 21,
            'username' => getenv('FTP_BUCKET_USER'),
            'password' => getenv('FTP_BUCKET_PASSWORD'),
            'root' => getenv('FTP_BUCKET_FILESYSTEM_BASE_PATH') ?: '/',
            'ssl' => getenv('FTP_BUCKET_SSL') ?: 0,
            'passive' => 1,
            'timeout' => 10,
            'transferMode' => defined('FTP_BINARY') ? FTP_BINARY : null,
            'enableTimestampsOnUnixListings' => true
        ],
        'i18n' => [
            'translations' => [
                '*' => $i18nTranslation,
                'app' => $i18nTranslation,
                'noty' => $i18nTranslation
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
            'useFileTransport' => getenv('APP_MAILER_USE_FILE_TRANSPORT'),
            'transport' => [
                'scheme' => getenv('APP_MAILER_SCHEME') ?: 'smtp',
                'host' => getenv('APP_MAILER_HOST'),
                'port' => (int)getenv('APP_MAILER_PORT'),
                'encryption' => getenv('APP_MAILER_ENCRYPTION'),
                'username' => getenv('APP_MAILER_USERNAME'),
                'password' => getenv('APP_MAILER_PASSWORD')
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'replyTo' => getenv('APP_MAILER_REPLY_TO'),
                'returnPath' => getenv('APP_MAILER_RETURN_PATH'),
                'from' => [getenv('APP_MAILER_FROM') => getenv('APP_TITLE')]
            ]
        ],
        'queue' => [
            'class' => Queue::class,
            'channel' => getenv('APP_QUEUE_CHANNEL'),
            'mutex' => 'queueMutex',
            'as log' => LogBehavior::class,
            'on ' . Queue::EVENT_AFTER_ERROR => function (ExecEvent $event) {
                if ($event->error instanceof Throwable) {
                    Yii::$app->getModule('audit')->exception($event->error);
                } else {
                    Yii::$app->getModule('audit')->errorMessage('Queue failed with an unspecified error.');
                }
            }
        ],
        'queueMutex' => [
            'class' => Mutex::class,
            'keyPrefix' => 'queue'
        ],
        'redis' => [
            'class' => RedisConnection::class,
            'hostname' => getenv('REDIS_PORT_6379_TCP_ADDR'),
            'port' => getenv('REDIS_PORT_6379_TCP_PORT')
        ],
        'session' => [
            'class' => DbSession::class,
            'db' => 'dbSystem',
            'cookieParams' => [
                'secure' => $isHttps
            ]
        ],
        'settings' => [
            'class' => Settings::class
        ],
        'user' => [
            'class' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
            'identityClass' => UserModel::class,
            'rootUsers' => ['admin']
        ],
        'urlManager' => [
            'class' => UrlManager::class,
            'cache' => YII_ENV_DEV ? null : 'cache',
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
                '#^img/download#' => '#^img/download#',
                '#^filefly/api#' => '#^filefly/api#'
            ],
            'languages' => $languages,
            'languageCookieOptions' => [
                'secure' => $isHttps
            ]
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
                        'Url' => ['class' => Url::class],
                        'Markdown' => ['class' => Markdown::class]
                    ],
                    'functions' => [
                        'image' => function ($imageSource, $preset = '') {
                            return ImageUrlHelper::image($imageSource, $preset);
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
            'class' => AuditModule::class,
            'accessRoles' => ['audit-module'],
            'layout' => $boxLayout,
            'panels' => [
                'audit/trail' => [
                    'class' => TrailPanel::class,
                    'maxAge' => null
                ],
                'audit/mail' => [
                    'class' => MailPanel::class,
                    'maxAge' => 30
                ],
                // Links the extra error reporting functions (`exception()` and `errorMessage()`)
                'audit/error' => [
                    'class' => ErrorPanel::class,
                    'maxAge' => 30
                ],
                'audit/extra' => [
                    'class' => ExtraDataPanel::class,
                    'maxAge' => 30
                ]
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
            'maxAge' => 7,
            'db' => 'dbSystem'
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
                'local' => 'fsLocal',
                'runtime' => 'fsRuntime'
            ],
            'urlCallback' => function ($item) {
                $urls = [];
                if ($item['type'] === 'file') {
                    $urls['Image'] = ImageUrlHelper::imageRelative($item['path']);
                    $urls['Download'] = ImageUrlHelper::downloadRelative($item['path']);
                }
                return $urls;
            },
        ],
        'gridview' => [
            'class' => GridViewModule::class
        ],
        'noty' => [
            'class' => NotyModule::class,
        ],
        'pages' => [
            'class' => PagesModule::class,
            'layout' => $boxLayout,
            'pageUseFallbackPage' => false,
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
            'root' => [
                '@app/views',
                '@vendor/loveorigami/yii2-notification-wrapper/src',
                '@vendor/dmstr',
                '@vendor/lajax/yii2-translate-manager',
                '@vendor/bedezign/yii2-audit/src'
            ],
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
            'enableGdprCompliance' => true,
            'defaultRoute' => 'admin',
            'administratorPermissionName' => 'user-module',
            'administrators' => ['admin'],
            'enableFlashMessages' => false,
            'generatePasswords' => true,
            'enableRegistration' => getenv('APP_USER_ENABLE_REGISTRATION'),
            'mailParams' => [
                'fromEmail' => [getenv('APP_MAILER_FROM') => getenv('APP_TITLE')]
            ],
            'gdprPrivacyPolicyUrl' => '/datenschutz'
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

if ($s3Enabled) {
    $common['components']['fsS3'] = [
        'class' => AwsS3Filesystem::class,
        'key' => getenv('AMAZON_S3_BUCKET_PUBLIC_KEY'),
        'secret' => getenv('AMAZON_S3_BUCKET_SECRET_KEY'),
        'bucket' => getenv('AMAZON_S3_BUCKET_NAME'),
        'prefix' => getenv('APP_NAME') . '/public',
        'region' => getenv('AMAZON_S3_BUCKET_REGION')
    ];

    $common['modules']['filefly']['filesystemComponents']['s3'] = 'fsS3';
}

return $common;
