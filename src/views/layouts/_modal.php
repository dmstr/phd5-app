<?php

use yii\helpers\Html;

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>

            <h3>
                <?= getenv('APP_NAME') ?>
            </h3>

            <p>
                <small>
                    <span class="label <?= YII_ENV_PROD ? 'label-success' : 'label-danger' ?>"><?= YII_ENV ?></span>
                    <span class="label label-warning <?= YII_DEBUG ? '' : 'hidden' ?>">debug</span>
                </small>

            </p>
            <p style="line-height: 1.6em">
                Application Version <span class="label label-info"><?= getenv('APP_NAME') ?>-<?= APP_VERSION ?></span>
                <br>
                Virtual Host <span class="label label-default"><?= isset($_SERVER['HTTP_HOST']) ?
                        $_SERVER['HTTP_HOST'] : '' ?></span>
                <br/>
                Hostname <span class="label label-default"><?= getenv('HOSTNAME') ?: 'local' ?></span>
            </p>

            <p class="small">
                Built with <?= Html::a('phd5', 'http://phd.dmstr.io') ?> from <?= Html::a('dmstr.io',
                    'http://www.diemeisterei.de') ?>
            </p>

            <hr/>

            <div class="pull-right">
                <?= Html::a('Backend', ['/backend'], ['class' => 'btn btn-default btn-xs']) ?>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</div>
