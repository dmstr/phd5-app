<?php

// @group mandatory

$I = new E2eTester($scenario);
$I->wantTo('ensure that widgets-module works');

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');


$I->amGoingTo('try to view and create widgets');

$I->amOnPage('/widgets');
$I->see('Widget contents', '.info-box');
$I->makeScreenshot('widgets');


$I->expect('to see widget container(s)');
$I->seeElement('//a[@href="/en/widgets/test/index"]');
$I->amOnPage('/widgets/test/index');
$I->moveMouseOver('.hrzg-widget-widget-container');
$I->makeScreenshot('widgets-frontend-container');


$I->amGoingTo('create a widget from a container');

$I->comment('Mouse-over first container');
$I->moveMouseOver('#cell-header.hrzg-widget-widget-container');
$I->waitForElementVisible('#cell-header .hrzg-widget-container-controls .btn-success', 2);
$I->click('#cell-header .hrzg-widget-container-controls .btn-success');
// TODO: fixme
$I->waitForElementVisible('#cell-header .hrzg-widget-container-controls ul', 2);
$I->click('#cell-header .hrzg-widget-container-controls .btn-success');
$I->waitForElementNotVisible('#cell-header .hrzg-widget-container-controls ul', 2);

$I->comment('Mouse-over second container');
$I->moveMouseOver('#cell-container.hrzg-widget-widget-container');
$I->waitForElementVisible('#cell-container .hrzg-widget-container-controls .btn-success', 2);
$I->click('#cell-container .hrzg-widget-container-controls .btn-success');
$I->waitForElementVisible('#cell-container .hrzg-widget-container-controls ul', 2);
$I->click('Content', '#cell-container .hrzg-widget-container-controls ul');

$I->switchToIFrame('backend-test');
$I->waitForElementVisible('.widget-create', 10);


$I->amGoingTo('select a widget');
$I->selectOption('#widgetcontent-widget_template_id', 'Content');
$I->waitForElementVisible('#widgetcontent-default_properties_json-container .well', 3);

$I->wantTo('ensure pre-filled values still exist');
$I->seeInField('#widgetcontent-route','widgets/test/index');
$I->fillField('root[title]', 'This is a test.');

$I->wantTo('ensure ckeditor works inside json editor');
$I->click('Add Paragraph', 'form#widget-create');
$I->waitForElementVisible('form .cke', 5);
$I->seeElement('form .cke_contents');

$I->makeScreenshot('widgets-backend-create-1');

$I->click('Create');
$I->wait(3);

$I->switchToIFrame();

$I->see('This is a test.', 'h2');