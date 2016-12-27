<?php

// @group mandatory

$I = new E2eTester($scenario);
$I->wantTo('ensure that widgets-module works');

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');
$I->amGoingTo('try to view and create widgets');

$I->amOnPage('/widgets');
$I->see('Widget contents', '.small-box');
$I->makeScreenshot('widgets');

$I->expect('to see widget container(s)');
$I->click('Test page index');
$I->moveMouseOver('.hrzg-widget-widget-container');
$I->makeScreenshot('widgets-frontend-container');

$I->amGoingTo('create a widget from a container');
$I->click('.hrzg-widget-container-controls .btn-success');
$I->waitForElementVisible('.widget-create', 10);

$I->amGoingTo('select a widget');
$I->selectOption('#widgetcontent-widget_template_id', 'Content');
$I->waitForElementVisible('#widgetcontent-default_properties_json-container .well', 3);

$I->wantTo('ensure pre-filled values still exist');
$I->seeInField('#widgetcontent-route','widgets/test/index');
$I->fillField('root[title]', 'This is a test.');

$I->makeScreenshot('widgets-backend-create-1');

$I->click('Create');

$I->wait(2);

$I->see('This is a test.', 'h2');