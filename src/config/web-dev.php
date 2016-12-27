<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

// Settings for web-application in development environment only
return [
    'bootstrap' => [
        'debug',
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // allow all private IPs by default
            'allowedIPs' => [
                '127.0.0.1',
                '::1',
                '10.*',
                '192.168.*',
                '172.16.*',
                '172.17.*',
                '172.18.*',
                '172.19.*',
                '172.20.*',
                '172.21.*',
                '172.22.*',
                '172.23.*',
                '172.24.*',
                '172.25.*',
                '172.26.*',
                '172.27.*',
                '172.28.*',
                '172.29.*',
                '172.30.*',
                '172.31.*',
            ],
        ],
    ],
];
