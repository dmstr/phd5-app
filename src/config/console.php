<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

use dektrium\rbac\commands\RbacController;
use hrzg\widget\commands\CopyController;

return [
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'audit' => \bedezign\yii2\audit\commands\AuditController::class,
        'db' => [
            'class' => \dmstr\console\controllers\MysqlController::class,
            'noDataTables' => [
                getenv('DATABASE_TABLE_PREFIX').'auth_assignment',
                getenv('DATABASE_TABLE_PREFIX').'migration',
                getenv('DATABASE_TABLE_PREFIX').'user',
                getenv('DATABASE_TABLE_PREFIX').'profile',
                getenv('DATABASE_TABLE_PREFIX').'token',
                getenv('DATABASE_TABLE_PREFIX').'social_account',
                getenv('DATABASE_TABLE_PREFIX').'log',
                getenv('DATABASE_TABLE_PREFIX').'session',
                getenv('DATABASE_TABLE_PREFIX').'audit_data',
                getenv('DATABASE_TABLE_PREFIX').'audit_entry',
                getenv('DATABASE_TABLE_PREFIX').'audit_error',
                getenv('DATABASE_TABLE_PREFIX').'audit_javascript',
                getenv('DATABASE_TABLE_PREFIX').'audit_mail',
                getenv('DATABASE_TABLE_PREFIX').'audit_trail',
                getenv('DATABASE_TABLE_PREFIX').'dmstr_contact_log',
                'filefly_hashmap', # TODO: fix prefix in module
            ],
        ],
        'fs' => [
            'class' => \hrzg\filefly\commands\FsController::class,
            'filesystemComponents' => [
                's3' => 'fsS3',
                'local' => 'fsLocal',
                'runtime' => 'fsRuntime',
            ],

        ],
        'migrate' => \dmstr\console\controllers\MigrateController::class,
        'resque' => \hrzg\resque\commands\ResqueController::class,
        'rbac' => RbacController::class,
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
                    'dirMode' => YII_ENV_DEV ? 0777 : null,
                    'fileMode' => YII_ENV_DEV ? 0666 : null,
                    'enabled' => YII_DEBUG && !YII_ENV_TEST,
                ],
            ],
        ],
    ],
];
