<?php

// @group mandatory

$I = new CliTester($scenario);

$I->runShellCommand('yii audit/cleanup --interactive=0');
$I->seeInShellOutput('skipped audit/trail');
$I->seeInShellOutput('skipped audit/mail');
$I->seeInShellOutput('Cleanup was successful');
