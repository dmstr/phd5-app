<?php

// @group mandatory
// @group init

$userName = \Codeception\Util\Fixtures::get('uniqid');

$I = new CliTester($scenario);

$I->amGoingTo('run the rbac command');
$I->runShellCommand("yii user/create {$userName}@test.local {$userName} test1234");
$I->runShellCommand("yii rbac/assign Editor {$userName}");
$I->canSeeInShellOutput('Role has been assigned');
$I->seeInShellOutput('Done.');
