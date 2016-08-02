<?php

// @group mandatory

$I = new CliTester($scenario);

$I->runShellCommand('/app/yii');
$I->seeInShellOutput('This is Yii version 2.0.');

$I->runShellCommand('cd / && yii');
$I->seeInShellOutput('This is Yii version 2.0.');

$I->runShellCommand('yii help');
$I->seeInShellOutput('The following commands are available');
$I->seeInShellOutput('user/create');
