<?php

// @group mandatory
// @group init

$I = new CliTester($scenario);

$I->runShellCommand('yii app/cleanup');
$I->seeInShellOutput('Cleanup');
$I->seeInShellOutput('Cleanup was successful.');
$I->seeInShellOutput('Web assets have been deleted.');

