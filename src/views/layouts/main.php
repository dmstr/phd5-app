<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace _;

use dmstr\helpers\SettingsAsset;
use dmstr\modules\backend\widgets\Modal;
use dmstr\modules\backend\widgets\Toolbar;
use dmstr\modules\prototype\widgets\TwigWidget;
use hrzg\widget\widgets\Cell;
use lo\modules\noty\layers\Growl;
use lo\modules\noty\Wrapper;
use Yii;
use yii\base\Event;
use yii\helpers\Html;
use yii\web\View;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title .= ' - ' . getenv('APP_TITLE');
$this->title = (getenv('APP_PAGES_TITLE_PREFIX') ?? '') . $this->title;

SettingsAsset::register($this);

if (getenv('APP_ASSET_DISABLE_BOOTSTRAP_BUNDLE')) {
    Event::on(
        View::class,
        View::EVENT_AFTER_RENDER,
        function ($e) {
            // disable unbundled asset
            $e->sender->assetBundles['yii\\bootstrap\\BootstrapAsset'] = null;
            // disable bundled asset
            $e->sender->assetBundles['bootstrap'] = null;
        }
    );
}

// Favicon
if ($favicon = \Yii::$app->settings->get('faviconPng', 'app.assets')) {
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

<?= TwigWidget::widget(['key' => '_beginBody', 'renderEmpty' => false]) ?>

<!-- Navbar -->
<?php
if (Yii::$app->settings->get('enableTwigNavbar', 'app.layout', false)) {
    echo TwigWidget::widget(['key' => '_navbar']);
} else {
    echo $this->render('_navbar');
}

?>

<!-- Content -->
<?= TwigWidget::widget(['key' => '_beforeContent', 'renderEmpty' => false]) ?>

<div class="wrap">

    <?= $content ?>

</div>

<?= TwigWidget::widget(['key' => '_afterContent', 'renderEmpty' => false]) ?>


<!-- Footer -->
<footer class="footer">
    <?= Cell::widget(['id' => '_footer', 'requestParam' => '_global']) ?>
</footer>

<!-- User flash messages -->
<?= Wrapper::widget([
    'layerClass' => Growl::class,
    'options' => [
        'dismissQueue' => true,
        'size' => 'medium',
        'location' => Yii::$app->settings->get('growl.location', 'frontend', 'br'),
        'timeout' => 4000,
    ],
]) ?>

<?= TwigWidget::widget(['key' => '_endBody', 'renderEmpty' => false]) ?>

<?php if (Yii::$app->user->can('backend_default_index')): ?>

    <?php if (Yii::$app->settings->get('backendWidget', 'frontend') === 'toolbar'): ?>
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

<?php endif; ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
