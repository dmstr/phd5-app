<?php

// @group mandatory

$I = new CliTester($scenario);

$I->runShellCommand('yii fs');
$I->seeInShellOutput('FlyCLI');

$I->runShellCommand('yii fs/ls local://');
