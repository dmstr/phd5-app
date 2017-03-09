<?php

// @group mandatory
// @group init

$I = new CliTester($scenario);

$I->runShellCommand('yii app/config');
$I->seeInShellOutput('id');

$I->runShellCommand('yii app/env');
$I->seeInShellOutput('APP_NAME');

$I->runShellCommand('yii app/version');
$I->seeInShellOutput('Application Version');