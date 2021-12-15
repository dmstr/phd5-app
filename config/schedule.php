<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

// cleanup with entrySolo, since panels have different default maxAge settings
$schedule->exec('yii audit/cleanup --interactive=0 --entrySolo')->daily();
