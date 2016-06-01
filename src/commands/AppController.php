<?php

namespace app\commands;

use yii\console\Controller;

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class AppController extends Controller
{
    public function actionSetup()
    {
        $this->stdout("Initializing application\n");

        $this->interactive = (bool) getenv('APP_INTERACTIVE');

        $this->run('db/create');
        $this->run('migrate/up', ['interactive'=>(bool) getenv('APP_INTERACTIVE')]);

        $adminPassword = $this->prompt(
            'Enter admin password',
            [
                'default' => getenv('APP_ADMIN_PASSWORD') ?: \Yii::$app->security->generateRandomString(8)
            ]
        );
        $this->run('user/create', ['admin@example.com', 'admin', $adminPassword]);

    }
}
