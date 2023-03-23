<?php

// @group mandatory

$I = new CliTester($scenario);

$I->runShellCommand('yii audit/cleanup --interactive=0');
$I->seeInShellOutput('skipped audit/trail');
$I->seeInShellOutput('cleaned audit/mail');
$I->seeInShellOutput('cleaned audit/error');
$I->seeInShellOutput('Cleanup was successful');
