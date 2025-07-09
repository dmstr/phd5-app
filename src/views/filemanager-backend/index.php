<?php
/**
 *
 * @var $this \yii\web\View
 * @var $fileSystemModuleId string
 * @var $fsApiModule \eluhr\flysystemRestApi\interfaces\FilesystemRestApiModuleInterface
 * @var string|null $jwt
 */


use yii\helpers\Html;

if (!is_string($jwt)) {
    echo Html::tag('div', 'No valid JWT given', ['class' => 'alert alert-warning']);
}

echo \eluhr\flysystemWidgets\widgets\Filemanager::widget([
    'fsApiModule' => $fsApiModule,
    'jwt' => $jwt
]);
