<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use bizley\jwt\Jwt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
// "Faked" values for testing
$_SERVER['HOST_NAME'] = 'web';
$_SERVER['REQUEST_TIME'] = time();

// check response code before rendering the page, if it is a redirect something went wrong
\yii\base\Event::on(
    \yii\web\View::class,
    \yii\web\View::EVENT_BEFORE_RENDER,
    function () {
        if (Yii::$app instanceof \yii\web\Application && Yii::$app->response->statusCode >= 300 && Yii::$app->response->statusCode < 400) {
            throw new \yii\web\HttpException(500, 'Unexpected response status code');
        }
    }
);

// For e2e tests, also for app integration tests in projects
$common = [
    'language' => 'en',
    'defaultRoute' => APP_TYPE == 'web' ? '/site/index' : 'help',
    'aliases' => [
        '@testProject' => '@root/tests/codeception/_project',
    ],
    'params' => [
        'backend.iframe.name' => 'backend-test',
    ],
    'components' => [
        'redis' => [
            'database' => 9
        ],
        'user' => [
            'loginUrl' => '/user/login'
        ],
        'jwt' => [
            'class' => Jwt::class,
            'signer' => Jwt::RS256,
            'signingKey' => [
                'key' => getenv('API_PRIVATE_KEY_FILE'),
                'method' => Jwt::METHOD_FILE
            ],
            'verifyingKey' => [
                'key' => getenv('API_PUBLIC_KEY_FILE'),
                'method' => Jwt::METHOD_FILE,
            ],
            'validationConstraints' => function (Jwt $jwt) {
                $config = $jwt->getConfiguration();
                return [
                    new SignedWith($config->signer(), $config->verificationKey()),
                ];
            }
        ],
    ],
    'modules' => [
        'test' => [
            'class' => testProject\modules\test\Module::class,
            'layout' => '@app/views/layouts/container',
        ]
    ]
];

return $common;
