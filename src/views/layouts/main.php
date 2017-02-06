<?php

namespace _;

/*
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use bedezign\yii2\audit\web\JSLoggingAsset;
use dmstr\modules\prototype\assets\DbAsset;
use hrzg\widget\widgets\Cell;
use rmrevin\yii\fontawesome\AssetBundle;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title .= ' - '.getenv('APP_TITLE');
// Register app asset or database asset bundle
if (\Yii::$app->settings->get('registerPrototypeAssetKey', 'app.assets', false)) {
    DbAsset::register($this);
} else {
    \app\assets\AppAsset::register($this);
}

// Register patch asset
if (\Yii::$app->settings->get('registerPatchAssetKey', 'app.assets', false)) {
    $patchAsset = new DbAsset();
    $patchAsset->settingsKey = \Yii::$app->settings->get('registerPatchAssetKey', 'app.assets');
    $patchAsset->register($this);
}

// Register font-awesome asset
if (\Yii::$app->settings->get('registerFontAwesomeAsset', 'app.assets', true)) {
    AssetBundle::register($this);
}


if (\Yii::$app->settings->get('registerJsLoggingAsset', 'app.assets', false)) {
    JSLoggingAsset::register($this);
}


// SEO
$route = Url::toRoute(Yii::$app->controller->action->uniqueId);
if ($keywords = \Yii::$app->settings->get($route, 'app.seo.keywords', null)) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
}
if ($description = \Yii::$app->settings->get($route, 'app.seo.descriptions', null)) {
    $this->registerMetaTag(['name' => 'description', 'content' => $description]);
}

if ($favicon = \Yii::$app->settings->get('faviconPng', 'app.assets', null)) {
    $this->registerLinkTag(['rel' => 'shortcut icon', 'type'=>'image/png', 'href' => $favicon]);
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?php
if (Yii::$app->settings->get('enableTwigNavbar', 'app.layout', false)) {
    echo \dmstr\modules\prototype\widgets\TwigWidget::widget(['key' => '_navbar']);
} else {
    echo $this->render('_navbar');
}

?>
<?= \dmstr\widgets\Alert::widget() ?>

<div class="wrap">
    <?= $content ?>
</div>

<footer class="footer">
    <?= Cell::widget(['id' => '_footer', 'requestParam' => '_global']) ?>
</footer>

<div class="phd-info" style="position: fixed; z-index: 1200; bottom: 0px; left: 10px; padding: 30px 0 0px; opacity: .3">
    <p>
    <?= Html::a(
        '<i class="fa fa-heartbeat"></i>',
        '#',
        ['class' => 'text-muted', 'data-toggle' => 'modal', 'data-target' => '#infoModal']
    ) ?>
    </p>
</div>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <?= $this->render('_modal') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
