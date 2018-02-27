<?php
/**
 * Configuration file for the "yii asset" console command.
 * Note that in the console environment, some path aliases like '@webroot' and '@web' may not exist.
 * Please define these missing path aliases.
 */

use lo\modules\noty\assets\GrowlAsset;
use yii\authclient\widgets\AuthChoiceAsset;

$basePath = '@app/../web/bundles';
$baseUrl = '@web/bundles';

$commonBundles = [
    \rmrevin\yii\fontawesome\AssetBundle::className(),
    \yii\bootstrap\BootstrapPluginAsset::className(),
    \yii\grid\GridViewAsset::className(),
    \yii\widgets\PjaxAsset::className(),
    \yii\widgets\ActiveFormAsset::className(),
    \yii\web\AssetBundle::className(),
    \yii\web\JqueryAsset::className(),
    \yii\validators\ValidationAsset::className(),
    AuthChoiceAsset::className(),
    GrowlAsset::className()
];

$bootstrapBundles = [
    \yii\bootstrap\BootstrapAsset::class
];

$frontendBundles = [
    \app\assets\AppAsset::className(),
];

$backendBundles = [
    \dmstr\modules\backend\assets\BackendAsset::className(),
    \dmstr\web\AdminLteAsset::className(),
    \kartik\tree\TreeViewAsset::className(),
];

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'uglifyjs {from} --mangle --compress --output {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'uglifycss {from} > {to}',
    // The list of asset bundles to compress:
    'bundles' => \yii\helpers\ArrayHelper::merge(
        $commonBundles,
        $frontendBundles,
        $backendBundles,
        $bootstrapBundles
    ),
    // Asset bundle for compression output:
    'targets' => [
        'frontend' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => $basePath,
            'baseUrl' => $baseUrl,
            'js' => 'frontend-{hash}.js',
            'css' => 'frontend-{hash}.css',
            'depends' => $frontendBundles,
        ],
        'backend' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => $basePath,
            'baseUrl' => $baseUrl,
            'js' => 'backend-{hash}.js',
            'css' => 'backend-{hash}.css',
            'depends' => $backendBundles,
        ],
        'bootstrap' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => $basePath,
            'baseUrl' => $baseUrl,
            'js' => 'bootstrap-{hash}.js',
            'css' => 'bootstrap-{hash}.css',
            'depends' => $bootstrapBundles,
        ],
        'all' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => $basePath,
            'baseUrl' => $baseUrl,
            'js' => 'common-{hash}.js',
            'css' => 'common-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '/app/web/bundles',
        'baseUrl' => '/bundles',
    ],
];
