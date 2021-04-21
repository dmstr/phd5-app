<?php
/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\widgets\Breadcrumbs;

$this->beginContent('@app/views/layouts/main.php');
?>

    <div class="container-layout">
        <div class="container">
            <?=
            Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        </div>

        <div class="container">
            <?= $content ?>
        </div>
    </div>

<?php $this->endContent(); ?>