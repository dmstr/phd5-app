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
    'bootstrap' => [
        'gii',
    ],
    'components' => [
        'view' => [
            'renderers' => [
                'twig' => [
                    'extensions' => (getenv('TWIG_DEBUG_MODE')) ? [new Twig_Extension_Debug()] : null,
                    'options' => [
                        'debug' => (getenv('TWIG_DEBUG_MODE')) ? true : false,
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
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
