<?php

// @group mandatory



$I = new E2eTester($scenario);
$I->wantTo('create a preview user');

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');

$I->amGoingTo('try to view and create pages');
$I->amOnPage('/user/admin/create');
$test = uniqid('test-');
#$preview = 'preview';
$I->fillField('#user-email', $test.'@example.com');
$I->fillField('#user-username', $test);
$I->fillField('#user-password', 'test1234');
$I->click('Save');
$I->wait(3);
$I->seeInPageSource('Update user account');
$I->makeScreenshot('success-preview-user');


$I->amGoingTo('assign permission to preview user');
$I->click('Assignments');

$I->waitForElementVisible('.select2-selection__rendered', 5);
$I->click('.select2-selection__rendered');

$I->waitForElementVisible('[id$="-Preview"]', 10);
$I->click('[id$="-Preview"]');
$I->waitForElementNotVisible('[id$="-Preview"]', 10);
$I->makeScreenshot('success-preview-items');

$I->click('Update assignments');
$I->wait(2);
$I->makeScreenshot('success-preview-items-update');

