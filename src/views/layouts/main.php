<?php

/*
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = $this->title;

// Register asset bundle
if (\Yii::$app->settings->get('registerPrototypeAssetKey', 'app.assets', false)) {
    \dmstr\modules\prototype\assets\DbAsset::register($this);
} else {
    \app\assets\AppAsset::register($this);
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

<?= $this->render('_navbar') ?>
<?= \dmstr\widgets\Alert::widget() ?>

<div class="wrap">
    <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <hr/>
        <p class="pull-left">
            <span class="label label-primary">dmstr</span>
        </p>
        <p class="pull-right">
            <span class="label label-default"><?= getenv('HOSTNAME') ?></span>
            <span class="label label-default"><?= getenv('APP_NAME') ?></span>
            <span class="label label-default"></span>
            <span class="label label-warning <?= YII_ENV_PROD ? 'label-success' : 'label-danger' ?>"><?= YII_ENV ?></span>
            <span class="label label-warning <?= YII_DEBUG ? '' : 'hidden' ?>">debug</span>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
