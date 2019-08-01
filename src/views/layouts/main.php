<?php

namespace _;

/*
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use dmstr\helpers\SettingsAsset;
use dmstr\modules\backend\widgets\Modal;
use dmstr\modules\backend\widgets\Toolbar;
use dmstr\modules\prototype\widgets\TwigWidget;
use hrzg\widget\widgets\Cell;
use lo\modules\noty\Wrapper;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title .= ' - '.getenv('APP_TITLE');
$this->title = (getenv('APP_PAGES_TITLE_PREFIX') ?? '').$this->title;

SettingsAsset::register($this);

if (getenv('APP_ASSET_DISABLE_BOOTSTRAP_BUNDLE')) {
    \yii\base\Event::on(
        \yii\web\View::className(),
        \yii\web\View::EVENT_AFTER_RENDER,
        function ($e) {
            // disable unbundled asset
            $e->sender->assetBundles['yii\\bootstrap\\BootstrapAsset'] = null;
            // disable bundled asset
            $e->sender->assetBundles['bootstrap'] = null;
        }
    );
}

// Favicon
if ($favicon = \Yii::$app->settings->get('faviconPng', 'app.assets', null)) {
    $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/png', 'href' => $favicon]);
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

<?php Pjax::begin([
    'id' => 'main-content',
    'timeout' => 5000,
    'linkSelector' => '.frontend-reload',
]) ?>

<?= TwigWidget::widget(['key' => '_beginBody', 'renderEmpty' => false]) ?>

<!-- Navbar -->
<?php
if (Yii::$app->settings->get('enableTwigNavbar', 'app.layout', false)) {
    echo \dmstr\modules\prototype\widgets\TwigWidget::widget(['key' => '_navbar']);
} else {
    echo $this->render('_navbar');
}

?>

<!-- Content -->
<div class="wrap">

    <?= $content ?>

</div>

<!-- Footer -->
<footer class="footer">
    <?= Cell::widget(['id' => '_footer', 'requestParam' => '_global']) ?>
</footer>

<?php Pjax::end() ?>

<!-- User flash messages -->
<?= Wrapper::widget([
    'layerClass' => 'lo\modules\noty\layers\Growl',
    'options' => [
        'dismissQueue' => true,
        'location' => 'br',
        'timeout' => 4000,
    ],
]) ?>

<?= TwigWidget::widget(['key' => '_endBody', 'renderEmpty' => false]) ?>

<?php if (Yii::$app->user->can('backend_default_index') && Yii::$app->settings->get('backendWidget', 'frontend') === 'toolbar'): ?>
    <?= Toolbar::widget([
        'useIframe' => \Yii::$app->settings->getOrSet(
            'useIframe',
            false,
            'backend.toolbar',
            'boolean'
        ),
    ]) ?>
<?php endif; ?>

<?php if (Yii::$app->settings->get('backendWidget', 'frontend') === 'modal'): ?>
    <?= Modal::widget() ?>
<?php endif; ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
