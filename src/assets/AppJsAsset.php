<?php
/**
 * @link http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Configuration for `backend` client script files.
 *
 * @since 4.0
 */
class AppJsAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/web';

    public $js = [
        'js/app.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class,
    ];
}
