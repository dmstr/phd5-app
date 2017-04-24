<?php

// @group mandatory
// @group init

$I = new CliTester($scenario);

$I->amGoingTo('run the rbac command');
$I->runShellCommand('yii rbac/assign Editor editor');
$I->canSeeInShellOutput('Auth-items have been assigned');
$I->seeInShellOutput('Done.');
