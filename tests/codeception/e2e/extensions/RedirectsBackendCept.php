<?php

// @group mandatory
// @group init

$redirectId = '__test-redirect';

$I = new E2eTester($scenario);
$I->wantTo("ensure that 'redirects' module works");

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');

$I->amOnPage('/redirects');
$I->click('New');

$I->waitForElementVisible('.redirect-form', 5);
$I->selectOption('Redirect[type]', 'Path redirect');
$I->fillField('Redirect[from_path]', '/'.$redirectId);
$I->fillField('Redirect[to_path]', '/user/profile');
$I->selectOption('#redirect-status_code input', 301);
$I->click('Create');
# TODO: It should not be possible to add the same redirect twice

$I->waitForElementNotVisible('.redirect-form');
$I->see($redirectId, 'table');

$I->makeScreenshot('redirect-create');
