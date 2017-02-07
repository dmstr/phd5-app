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
                'app_auth_assignment',
                'app_migration',
                'app_user',
                'app_profile',
                'app_token',
                'app_social_account',
                'app_log',
                'app_session',
                'moxman_cache',
                'moxman_hashmap',
                'app_audit_data',
                'app_audit_entry',
                'app_audit_error',
                'app_audit_javascript',
                'app_audit_mail',
                'app_audit_trail',
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
