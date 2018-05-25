<?php

// @group mandatory

$dir = \Codeception\Util\Fixtures::get('uniqid');

$I = new CliTester($scenario);

$I->runShellCommand('yii fs');
$I->seeInShellOutput('FlyCLI');

$I->runShellCommand('yii fs/mkdir local://'.$dir);

$I->runShellCommand('yii fs/ls local://');
$I->seeInShellOutput($dir);

$I->runShellCommand('yii fs/rmdir local://'.$dir);
$I->dontSeeInShellOutput($dir);