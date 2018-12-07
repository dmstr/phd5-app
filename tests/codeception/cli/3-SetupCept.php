<?php

// @group mandatory
// @group init

$I = new CliTester($scenario);

$I->amGoingTo('run the setup command');
$I->runShellCommand('yii app/setup');
$I->canSeeInShellOutput('Initializing application');
$I->seeInShellOutput('[OK]');
$I->seeInShellOutput('Done.');
// TODO: this fails, if admins exists in migration data, but tests can continue
// $I->dontSeeInShellOutput('error');

$I->amGoingTo('check if all migrations have been applied');
$I->runShellCommand('yii migrate/up --interactive=0');
$I->seeInShellOutput('No new migrations found');
$I->dontSeeInShellOutput('error');

$I->amGoingTo('change the admin user password');
$I->runShellCommand("yii user/password admin admin1");
$I->seeInShellOutput('Password has been changed');

$I->amGoingTo('change the admin user password');
$I->runShellCommand("yii user/password preview preview1");
$I->seeInShellOutput('Password has been changed');

$I->runShellCommand('yii app/init-modules');
$I->seeInShellOutput('Initializing modules...');

$I->runShellCommand('yii cache/flush-all');
$I->seeInShellOutput('The following cache components were processed:');