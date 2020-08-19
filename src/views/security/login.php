<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2020 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * --- VARIABLES FROM CONTROLLER ---
 *
 * @var LoginForm $model
 */

use Da\User\Form\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="login-box">
    <div class="login-logo">
        <?= Html::a(getenv('APP_TITLE'), ['']) ?>
    </div>
    <div class="login-box-body">
        <?php
        $form = ActiveForm::begin([
            'action' => ['/user/login'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validateOnBlur' => false,
            'validateOnType' => false,
            'validateOnChange' => false,
        ]);
        ?>

        <?= $form->field($model, 'login', [
            'inputOptions' => [
                'autofocus' => 'autofocus',
                'class' => 'form-control',
                'tabindex' => '1'
            ]
        ]) ?>

        <?= $form->field($model, 'password')->passwordInput([
            'class' => 'form-control',
            'tabindex' => '2'
        ]) ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'tabindex' => '4'
        ]) ?>

        <?= Html::submitButton(Yii::t('app', 'Sign in'), [
            'class' => 'btn btn-primary btn-block',
            'tabindex' => '3'
        ]) ?>

        <?php
        ActiveForm::end()
        ?>
    </div>
</div>
