<?php

namespace app\commands;

use dektrium\user\models\User;
use mikehaertl\shellcommand\Command;
use yii\console\Controller;
use yii\helpers\VarDumper;

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */
class AppController extends Controller
{
    public $defaultAction = 'version';

    /**
     * Shows application configuration
     * Note that this action shows console configuration.
     *
     * @param null $key configuration section
     */
    public function actionConfig($key = null)
    {
        // get config from global variable (TODO)
        $data = $GLOBALS['config'];
        if ($key) {
            $keys = explode('.', $key);
            if (isset($keys[0])) {
                $data = $GLOBALS['config'][$keys[0]];
            }
            if (isset($keys[1])) {
                $data = $GLOBALS['config'][$keys[0]][$keys[1]];
            }
        }
        $this->stdout(VarDumper::dumpAsString($data));
    }

    /**
     * Shows application environment variables.
     */
    public function actionEnv()
    {
        $env = $_ENV;
        ksort($env);
        $this->stdout(VarDumper::dumpAsString($env));
    }

    /**
     * Displays application version from APP_VERSION constant.
     */
    public function actionVersion()
    {
        $this->stdout('Application Version: ');
        $this->stdout(getenv('APP_NAME').' ');
        $this->stdout(APP_VERSION);
        echo "\n";
    }

    /**
     * Initializes application.
     */
    public function actionSetup()
    {
        $this->stdout("\n");
        $this->stdout("phd application setup\n");
        $this->stdout("=====================\n");
        $this->stdout("Initializing application\n");

        $this->interactive = (bool)getenv('APP_INTERACTIVE');

        $this->stdout("\nDatabase\n");
        $this->stdout("--------\n");
        $this->run('db/create');
        $this->run('migrate/up', ['interactive' => (bool)getenv('APP_INTERACTIVE')]);

        $this->stdout("\nUser\n");
        $this->stdout("----\n");
        $adminPassword = $this->prompt(
            'Enter admin password',
            [
                'default' => getenv('APP_ADMIN_PASSWORD') ?: \Yii::$app->security->generateRandomString(8),
            ]
        );
        $this->run('user/create', [getenv('APP_ADMIN_EMAIL'), 'admin', $adminPassword]);

        $this->stdout("\n\nDone.\n");
    }

    /**
     * Clean cache, assets and audit tables
     */
    public function actionCleanup()
    {
        $this->stdout("\nCleanup\n");
        $this->stdout("-------\n");
        $this->run('cache/flush-all');
        $this->run('audit/cleanup', ['age' => 30, 'interactive' => (bool)getenv('APP_INTERACTIVE')]);
        $this->run('app/clear-assets', ['interactive' => (bool)getenv('APP_INTERACTIVE')]);
    }

    /**
     * Clear [application]/web/assets folder.
     */
    public function actionClearAssets()
    {
        $assets = \Yii::getAlias('@web/assets');

        // Matches from 7-8 char folder names, the 8. char is optional
        $matchRegex = '"^[a-z0-9][a-z0-9][a-z0-9][a-z0-9][a-z0-9][a-z0-9][a-z0-9]\?[a-z0-9]$"';

        // create $cmd command
        $cmd = 'cd "'.$assets.'" && ls | grep -e '.$matchRegex.' | xargs rm -rf ';

        // Set command
        $command = new Command($cmd);

        // Prompt user
        $delete = $this->confirm("\nDo you really want to delete web assets?", ['default' => true]);

        if ($delete) {
            // Try to execute $command
            if ($command->execute()) {
                echo "Web assets have been deleted.\n\n";
            } else {
                echo "\n".$command->getError()."\n";
                echo $command->getStdErr();
            }
        }
    }
}
