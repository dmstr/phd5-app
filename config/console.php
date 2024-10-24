<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

return [
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'audit' => \bedezign\yii2\audit\commands\AuditController::class,
        'db' => [
            'class' => \dmstr\console\controllers\MysqlController::class,
            'excludeTables' => [
                getenv('DATABASE_TABLE_PREFIX') . 'auth_assignment',
                getenv('DATABASE_TABLE_PREFIX') . 'migration',
                getenv('DATABASE_TABLE_PREFIX') . 'user',
                getenv('DATABASE_TABLE_PREFIX') . 'profile',
                getenv('DATABASE_TABLE_PREFIX') . 'token',
                getenv('DATABASE_TABLE_PREFIX') . 'social_account',
                getenv('DATABASE_TABLE_PREFIX') . 'log',
                getenv('DATABASE_TABLE_PREFIX') . 'session',
                getenv('DATABASE_TABLE_PREFIX') . 'audit_data',
                getenv('DATABASE_TABLE_PREFIX') . 'audit_entry',
                getenv('DATABASE_TABLE_PREFIX') . 'audit_error',
                getenv('DATABASE_TABLE_PREFIX') . 'audit_javascript',
                getenv('DATABASE_TABLE_PREFIX') . 'audit_mail',
                getenv('DATABASE_TABLE_PREFIX') . 'audit_trail',
                getenv('DATABASE_TABLE_PREFIX') . 'dmstr_contact_log',
                getenv('DATABASE_TABLE_PREFIX') . 'queue_manager',
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
                    '@bedezign/yii2/audit/migrations/1.1.x',
                    '@dmstr/modules/contact/migrations',
                    '@dmstr/modules/pages/migrations',
                    '@dmstr/modules/publication/migrations',
                    '@dmstr/modules/redirect/migrations',
                    '@dmstr/modules/backend/migrations',
                    '@hrzg/filefly/migrations',
                    '@hrzg/widget/migrations',
                    '@vendor/lajax/yii2-translate-manager/migrations',
                    '@vendor/pheme/yii2-settings/migrations',
                    '@vendor/dmstr/yii2-prototype-module/src/migrations',
                    '@vendor/dmstr/yii2-resque-module/src/migrations/2.0-to-3.0'
                ]
            ),
            'migrationNamespaces' => [
                Da\User\Migration::class,
                'yii\queue\db\migrations'
            ],
        ],
        'rbac' => \dmstr\helpers\RbacController::class,
        'translate' => \lajax\translatemanager\commands\TranslatemanagerController::class
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
        'dbSystem' => [
            'on ' . yii\db\Connection::EVENT_AFTER_OPEN => function ($event) {
                if ($event->sender->driverName === 'mysql') {
                    // set session wait_timeout for this connection to mysql default value to prevent connection-timeouts
                    // in e.g. audit module while exec long-running CLI processes
                    $event->sender->createCommand(
                        'SET SESSION wait_timeout = :timeout;',
                        [
                            ':timeout' => (int)getenv('DB_ENV_MYSQL_CLI_WAIT_TIMEOUT') ?: 28800
                        ]
                    )->execute();
                }
            },
        ],

    ],
    'modules' => [
        'user' => [
            'allowPasswordRecovery' => false
        ]
    ]
];
