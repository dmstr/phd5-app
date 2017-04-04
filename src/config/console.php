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
        'audit' => 'bedezign\yii2\audit\commands\AuditController',
        'migrate' => 'dmstr\console\controllers\MigrateController',
        'translate' => 'lajax\translatemanager\commands\TranslatemanagerController',
        'resque' => 'hrzg\resque\commands\ResqueController',
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
            ],
        ],
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
