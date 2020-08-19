<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2020 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers;

use Da\User\Form\LoginForm;
use Da\User\Traits\ContainerAwareTrait;
use dmstr\web\AdminLteAsset;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Security controller.
 */
class SecurityController extends Controller
{
    use ContainerAwareTrait;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access-control'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'login'
                    ],
                    'roles' => [
                        '?',
                        '@'
                    ]
                ]
            ]
        ];
        return $behaviors;
    }

    /**
     * Renders the login page.
     *
     * @throws InvalidConfigException
     * @return string
     */
    public function actionLogin()
    {
        if (Yii::$app->user->isGuest === false) {
            return $this->goHome();
        }

        AdminLteAsset::register($this->view);
        $this->view->title = Yii::t('app', 'Sign in');
        $this->layout = '@app/views/layouts/plain';

        return $this->render('login', [
            'model' => $this->make(LoginForm::class)
        ]);
    }
}
