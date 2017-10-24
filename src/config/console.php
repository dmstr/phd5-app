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

return [
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'audit' => 'bedezign\yii2\audit\commands\AuditController',
        'db' => [
            'class' => 'dmstr\console\controllers\MysqlController',
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
            'class' => '\hrzg\filefly\commands\FsController',
            'filesystemComponents' => [
                's3' => 'fsS3',
                'local' => 'fsLocal',
                'runtime' => 'fsRuntime',
            ],

        ],
        'migrate' => 'dmstr\console\controllers\MigrateController',
        'resque' => 'hrzg\resque\commands\ResqueController',
        'rbac' => RbacController::className(),
        'translate' => 'lajax\translatemanager\commands\TranslatemanagerController',
    ],
    'components' => [
        'log' => [
            'targets' => [
                // writes to php-fpm output stream
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/console.log',
                    //'levels' => ['info', 'trace'],
                    'logVars' => [],
                    'enabled' => YII_DEBUG && !YII_ENV_TEST,
                ],
            ],
        ],
    ],
];
