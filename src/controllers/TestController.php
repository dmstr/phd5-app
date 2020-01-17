<?php

namespace app\controllers;

/*
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use dmstr\web\traits\AccessBehaviorTrait;
use yii\web\Controller;

/**
 * Site controller.
 */
class TestController extends Controller
{
    use AccessBehaviorTrait;

    public function actionConsent()
    {
        return $this->render('consent');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

}
