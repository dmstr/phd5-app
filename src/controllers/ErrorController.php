<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller.
 */
class ErrorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => ErrorAction::class,
            ]
        ];
    }
}
