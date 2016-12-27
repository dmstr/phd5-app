<?php

// @group mandatory

$rootPath = realpath(__DIR__.'/../../..');

$I = new FunctionalTester($scenario);

$I->wantTo('check application versioning');

$I->dontSeeFileFound('version', $rootPath);
$I->seeFileFound('version', $rootPath.'/src');

$I->openFile($rootPath.'/src/version');

$I->dontSeeInThisFile('dev');
$I->dontSeeInThisFile('dirty');
