<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>

            <p>
            <h3><?= getenv('APP_TITLE') ?></h3>
            <small>
                <span class="label <?= YII_ENV_PROD ? 'label-success' : 'label-danger' ?>"><?= YII_ENV ?></span>
                <span class="label label-warning <?= YII_DEBUG ? '' : 'hidden' ?>">debug</span>
            </small>
            </p>

            <table class="table">
                <tr>
                    <th>Name</th>
                    <td><code><?= getenv('APP_NAME') ?></code></td>
                </tr>
                <tr>
                    <th>Version</th>
                    <td><code><?= APP_VERSION ?></code></td>
                </tr>
                <tr>
                    <th>Virtual Host</th>
                    <td><code><?= isset($_SERVER['HTTP_HOST']) ?
                                $_SERVER['HTTP_HOST'] : 'n/a' ?></code></td>
                </tr>
                <tr>
                    <th>Hostname</th>
                    <td><code><?= getenv('HOSTNAME') ?: 'local' ?></code></td>
                </tr>
            </table>

            <div class="pull-left">
                <p class="small">
                    Built with <?= Html::a('phd', 'http://phd.dmstr.io') ?> from <?= Html::a('dmstr',
                        'http://www.diemeisterei.de') ?>
                </p>
            </div>

            <div class="pull-right">
                <?= Html::a(FA::icon(FA::_COG), ['/backend'], ['class' => 'btn btn-default btn-xs']) ?>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</div>
