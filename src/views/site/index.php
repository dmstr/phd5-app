<?php
/* @var $this yii\web\View */
$this->title .= 'Home';
?>

<div class="site-index">

    <div class="jumbotron">
        <div class="container">
            <h1><?= getenv('APP_TITLE') ?></h1>
        </div>
    </div>
    <div class="container">
        <?= \dmstr\modules\prototype\widgets\HtmlWidget::widget(['enableFlash' => true]) ?>
    </div>

</div>
