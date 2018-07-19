<?php

// @group mandatory
// @group init

$userName = \Codeception\Util\Fixtures::get('uniqid');

$I = new CliTester($scenario);

$I->amGoingTo('run the rbac command');
$I->runShellCommand("yii user/create {$userName}@test.local {$userName} test1234");
$I->canSeeInShellOutput('User has been created!');
$I->runShellCommand("yii rbac/assign Editor {$userName}");
$I->canSeeInShellOutput('Role has been assigned');

$I->runShellCommand("yii rbac/assign Editor {$userName}");
$I->canSeeInShellOutput('Role is already assigned to this user');

$I->runShellCommand("yii rbac/revoke Editor {$userName}");
$I->canSeeInShellOutput('Role has been revoked');

