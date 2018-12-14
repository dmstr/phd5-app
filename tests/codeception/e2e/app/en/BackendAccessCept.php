<?php

// @group mandatory
// @group long-running

$I = new E2eTester($scenario);

$I->wantTo('ensure backend access works');

$I->expectTo('have no access without login');
$I->amOnPage('/backend');
$I->dontSeeElement('.small-box');
$I->amOnPage('/prototype/html');
$I->dontSee('Htmls', 'h1');
$I->amOnPage('/prototype/less');
$I->dontSee('Lesses', 'h1');
$I->amOnPage('/settings');
$I->dontSee('Settings', 'h1');

$I->expectTo('have no access with login');
$I->login('master', 'master1');

$I->amOnPage('/backend');
$I->makeScreenshot('backend-dashboard');

$I->amOnPage('/backend/default/view-config');
$I->see('Components', 'li');
$I->see('Modules', 'li');
$I->makeScreenshot('backend-view-config');

$I->amOnPage('/prototype/html');
$I->see('Htmls', 'h1');
$I->amOnPage('/prototype/less');
$I->see('Lesses', 'h1');

$I->amOnPage('/settings');
$I->see('Settings', 'h1');

$I->amOnPage('/user');
$I->see('Users', 'li');
$I->see('Roles', 'li');
$I->see('Permissions', 'li');
$I->makeScreenshot('user-admin');

$I->amOnPage('/resque/manage');
$I->see('Workers', '.small-box');