<?php
/* @var $this yii\web\View */
$this->title .= Yii::t('app', '__TITLE_HOME__');
?>

<div class="site-index">

    <?= \dmstr\modules\prototype\widgets\TwigWidget::widget(['registerMenuItems' => true]) ?>

</div>
