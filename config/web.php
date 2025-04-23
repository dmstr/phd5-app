<?php
/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

use bedezign\yii2\audit\components\web\ErrorHandler;
use codemix\streamlog\Target;
use dmstr\modules\backend\interfaces\ContextMenuItemsInterface;
use pheme\settings\Module as SettingsModule;
use schmunk42\markdocs\Module as MarkdocsModule;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\JsonParser;
use yii\widgets\ActiveForm;

// Disable the submit-button while submitting to prevent duplicated requests
Event::on(ActiveForm::class, ActiveForm::EVENT_INIT, function () {
    Yii::$app->controller->view->registerJs(<<<JS
$(document).on('beforeSubmit', 'form', function() {
    $(this).find('[type=submit]').attr('disabled', true).addClass('disabled');
});
JS
    );
});

// Settings for web-application only
return [
    'on registerMenuItems' => function ($event) {
        if ($event->sender instanceof ContextMenuItemsInterface) {
            Yii::$app->params['context.menuItems'] = ArrayHelper::merge(
                Yii::$app->params['context.menuItems'],
                $event->sender->getMenuItems()
            );
        }
        $event->handled = true;
    },
    'components' => [
        'cookieConsentHelper' => [
            'class' => dmstr\cookieconsent\components\CookieConsentHelper::class
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class,
            'errorAction' => 'error/index',
        ],
        'log' => [
            'targets' => [
                // writes to php-fpm output stream
                'web' => [
                    'class' => Target::class,
                    'url' => 'php://stdout',
                    'levels' => ['info', 'trace'],
                    'logVars' => [],
                    'replaceNewline' => YII_DEBUG ? null : '',
                    'enabled' => YII_DEBUG && !YII_ENV_TEST,
                ],

            ],
        ],
        'request' => [
            'cookieValidationKey' => getenv('APP_COOKIE_VALIDATION_KEY'),
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],
    ],
    'modules' => [
        'docs' => [
            'class' => MarkdocsModule::class,
            'layout' => '@backend/views/layouts/box',
            'enableEmojis' => true,
        ],
        'settings' => [
            'class' => SettingsModule::class,
            'layout' => '@backend/views/layouts/box',
            'accessRoles' => ['settings-module'],
        ],
    ],
];
