<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
return [
    'language' => 'en',
    'defaultRoute' => APP_TYPE == 'web' ? '/site/index' : 'help',
    'aliases' => [
        '@testProject' => '@root/tests/codeception/_project',
    ],
    'params' => [
        'backend.iframe.name' => 'backend-test',
    ],
    'components' => [
        'user' => [
            'loginUrl' => '/user/login'
        ]
    ],
    'modules' => [
        'test' => [
            'class' => testProject\modules\test\Module::class,
            'layout' => '@app/views/layouts/container',
        ]
    ]
];
