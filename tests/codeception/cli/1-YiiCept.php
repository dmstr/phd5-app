<?php

// @group mandatory
// @group init

$I = new CliTester($scenario);

$I->runShellCommand('yii');
$I->seeInShellOutput('This is Yii version 2.0.');
$I->dontSeeInShellOutput('warning');

$I->runShellCommand('cd / && yii');
$I->seeInShellOutput('This is Yii version 2.0.');

$I->runShellCommand('yii help');
$I->seeInShellOutput('The following commands are available');
$I->seeInShellOutput('- db');
$I->seeInShellOutput('app/setup');
$I->seeInShellOutput('user/create');
