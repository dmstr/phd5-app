<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

use hrzg\widget\commands\CopyController;

return [
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'audit' => \bedezign\yii2\audit\commands\AuditController::class,
        'db' => [
            'class' => \dmstr\console\controllers\MysqlController::class,
            'includeTables' => [
                getenv('DATABASE_TABLE_PREFIX') . 'auth_rule',
                getenv('DATABASE_TABLE_PREFIX') . 'auth_item',
                getenv('DATABASE_TABLE_PREFIX') . 'auth_item_child',
                getenv('DATABASE_TABLE_PREFIX') . 'dmstr_page',
                getenv('DATABASE_TABLE_PREFIX') . 'dmstr_page_translation',
                getenv('DATABASE_TABLE_PREFIX') . 'dmstr_page_translation_meta',
                getenv('DATABASE_TABLE_PREFIX') . 'hrzg_widget_template',
                getenv('DATABASE_TABLE_PREFIX') . 'hrzg_widget_content',
                getenv('DATABASE_TABLE_PREFIX') . 'hrzg_widget_content_translation',
                getenv('DATABASE_TABLE_PREFIX') . 'hrzg_widget_content_translation_meta',
                getenv('DATABASE_TABLE_PREFIX') . 'html',
                getenv('DATABASE_TABLE_PREFIX') . 'language',
                getenv('DATABASE_TABLE_PREFIX') . 'language_source',
                getenv('DATABASE_TABLE_PREFIX') . 'language_translate',
                getenv('DATABASE_TABLE_PREFIX') . 'less',
                getenv('DATABASE_TABLE_PREFIX') . 'settings',
                getenv('DATABASE_TABLE_PREFIX') . 'twig',
                'dmstr_redirect',
                'filefly_hashmap', # TODO: fix prefix in module
            ],
        ],
        'fs' => [
            'class' => \hrzg\filefly\commands\FsController::class,
        ],
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => \yii\helpers\ArrayHelper::merge(
                explode(',', getenv('APP_MIGRATION_LOOKUP')),
                [
                    '@yii/rbac/migrations',
                    '@yii/web/migrations',
                    '@app/migrations/legacy/migration-command',
                    '@app/migrations/5.2-to-5.3',
                    '@bedezign/yii2/audit/migrations',
                    '@dmstr/modules/contact/migrations',
                    '@dmstr/modules/pages/migrations',
                    '@dmstr/modules/publication/migrations',
                    '@dmstr/modules/redirect/migrations',
                    '@dmstr/modules/backend/migrations',
                    '@hrzg/filefly/migrations',
                    '@hrzg/widget/migrations',
                    '@ignatenkovnikita/queuemanager/migrations',
                    '@vendor/lajax/yii2-translate-manager/migrations',
                    '@vendor/pheme/yii2-settings/migrations',
                    '@vendor/dmstr/yii2-prototype-module/src/migrations',
                ]
            ),
            'migrationNamespaces' => [
                Da\User\Migration::class
            ],
        ],
        'rbac' => \dmstr\helpers\RbacController::class,
        'translate' => \lajax\translatemanager\commands\TranslatemanagerController::class,
        'widgets-copy' => CopyController::class
    ],
    'components' => [
        'log' => [
            'targets' => [
                // writes to php-fpm output stream
                'console' => [
                    'class' => \yii\log\FileTarget::class,
                    'logFile' => '@runtime/logs/console.log',
                    //'levels' => ['info', 'trace'],
                    'logVars' => [],
                    'dirMode' => YII_ENV_DEV ? 0777 : 0775,
                    'fileMode' => YII_ENV_DEV ? 0666 : null,
                    'enabled' => YII_DEBUG && !YII_ENV_TEST,
                ],
            ],
        ],
    ],
];
