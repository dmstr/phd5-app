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

// SEO
$route = Url::toRoute(Yii::$app->controller->action->uniqueId);
if ($keywords = \Yii::$app->settings->get($route, 'app.seo.keywords', null)) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
}
if ($description = \Yii::$app->settings->get($route, 'app.seo.descriptions', null)) {
    $this->registerMetaTag(['name' => 'description', 'content' => $description]);
}
if ($title = \Yii::$app->settings->get($route, 'app.seo.titles', null)) {
    $this->title = $title;
}
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

<!-- Info Modal -->
<div id="phd-info-button"
     style="position: fixed; z-index: 1200; bottom: 0px; left: 10px; padding: 30px 0 0px; opacity: .3">
    <p>
        <?= Html::a(
            '<i class="fa fa-heartbeat"></i>',
            '#',
            ['class' => 'text-muted', 'data-toggle' => 'modal', 'data-target' => '#phd-info-modal']
        ) ?>
    </p>
</div>
<div class="modal fade" id="phd-info-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <?= $this->render('_modal') ?>
</div>

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

<?php if (Yii::$app->user->can('backend_default_index')): ?>
    <?= Toolbar::widget([
        'useIframe' => \Yii::$app->settings->getOrSet(
            'useIframe',
            false,
            'backend.toolbar',
            'boolean'
        ),
    ]) ?>
<?php endif; ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
