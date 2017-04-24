<?php

namespace app\assets;

/*
 * @link http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * Configuration for `backend` client script files.
 *
 * @since 4.0
 */
class AppJsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/web';

    public $js = [
        'js/app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
