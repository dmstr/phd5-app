<?php

// @group mandatory

//use tests\codeception\_pages\LoginPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that access control UI works');

$I->amOnPage('/');
$I->dontSeeLink('/en/backend', '.nav');
$I->dontSee('','.glyphicon.glyphicon-cog');

$I->login('admin', 'admin1');

$I->see('','.glyphicon.glyphicon-cog');
