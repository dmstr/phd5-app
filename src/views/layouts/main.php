<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = $this->title;

\yii\bootstrap\BootstrapAsset::register($this);

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

<div class="wrap">
    <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <hr/>
        <p>
            <span class="label label-info"><?= getenv('HOSTNAME') ?></span>
            <span class="label label-info"><?= getenv('APP_NAME') ?></span>
            <span class="label label-default"><?= YII_ENV ?></span>
            <span class="label label-warning"><?= YII_DEBUG ?></span>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
