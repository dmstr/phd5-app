<?php

// @group mandatory

$I = new CliTester($scenario);

$I->runShellCommand('yii db/x-dump-data');
$I->seeInShellOutput('success');
