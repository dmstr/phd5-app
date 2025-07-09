<?php
/**
 * This is a simple backend controller for dev purpose
 * it requires the eluhr/yii2-flysystem-widgets package
 */

namespace eluhr\flysystemRestApi\controllers;

use yii\web\Controller;

class BackendController extends Controller
{

    public function init()
    {
        parent::init();
        if (!empty($this->module->backendLayout)) {
            $this->layout = $this->module->backendLayout;
        }
    }


    public function actionIndex()
    {
        return $this->render('index', [
            'fsApiModule' => $this->module,
            'jwt' => \Yii::$app->getUser()?->getIdentity()?->getJwt()?->toString()
        ]);
    }

}
