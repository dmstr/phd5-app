<?php
/**
 * This is a simple backend controller for dev purpose
 * it requires the eluhr/yii2-flysystem-widgets package
 *
 * DELETE THIS CONTROLLER BEFORE MAKING A RELEASE
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class FilemanagerBackendController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'matchCallback' => function () {
                        return !Yii::$app->getUser()->getIsGuest() && (YII_ENV_DEV || Yii::$app->getUser()->can('Admin'));
                    },
                    'allow' => true,
                ]
            ]
        ];
        return $behaviors;
    }

    public $layout = '@backend/views/layouts/box';

    public function actionIndex()
    {
        return $this->render('index', [
            'fsApiModule' => \Yii::$app->getModule('filemanager'),
            'jwt' => \Yii::$app->getUser()?->getIdentity()?->getJwt()?->toString()
        ]);
    }
}
