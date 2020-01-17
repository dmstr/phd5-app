<?php

namespace project\modules\test\controllers;

/*
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use yii\web\Controller;

/**
 * Site controller.
 */
class CookieConsentController extends Controller
{
    public function actionConsent()
    {
        return $this->render('consent');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }
}
