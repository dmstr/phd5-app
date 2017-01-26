<?php

// @group mandatory

$rootPath = realpath(__DIR__.'/../../..');

$I = new FunctionalTester($scenario);

$I->wantTo('check application versioning');

$I->amGoingTo('check files in root path: '. $rootPath);
$I->dontSeeFileFound('./version', $rootPath);

$I->amGoingTo('check files in root path: '. $rootPath.'/src');
$I->seeFileFound('version', $rootPath.'/src');
$I->openFile($rootPath.'/src/version');

$I->dontSeeInThisFile('dev');
$I->dontSeeInThisFile('dirty');
