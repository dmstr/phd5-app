<?php

// @group essential

$I = new CliTester($scenario);

$I->runShellCommand('yii app/clear-assets --interactive=0');
$I->seeInShellOutput('Web assets have been deleted');