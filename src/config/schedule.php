<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

$schedule->exec('yii audit/cleanup --interactive=0 --entry --age=7')->daily();
