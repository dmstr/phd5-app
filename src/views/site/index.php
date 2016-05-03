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
        <h2>Start development bash</h2>
        <p class="well">
            <code>
                make bash
            </code>
        </p>
        <h2>Install packages</h2>
        <p class="well">
            <code>
                $ composer require "dmstr/yii2-cms-metapackage" "dmstr/yii2-cms-dev-metapackage"
            </code>
        </p>
        <p>
            <?= \yii\helpers\Html::a(
                'Online Documentation',
                'https://github.com/dmstr/solid-ground',
                ['target' => '_blank']) ?>

        </p>
    </div>

</div>
