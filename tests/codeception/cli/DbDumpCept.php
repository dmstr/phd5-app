<?php

// @group mandatory

$I = new CliTester($scenario);

$I->runShellCommand('yii db/export');
$I->seeInShellOutput('success');
