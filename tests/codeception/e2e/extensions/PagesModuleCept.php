<?php

// @group mandatory

$uniqId = uniqid('Test-');

$I = new E2eTester($scenario);
$I->wantTo('ensure that Pages works');

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');
$I->amGoingTo('try to view and create pages');
$I->amOnPage('/pages');
$I->see('Nodes', '.kv-heading-container');
$I->makeScreenshot('success-pages-index');

$I->amGoingTo("Check/load the root node of 'en'");
$I->click('li[data-key="1001"] .kv-node-detail');
$I->waitForElementVisible('.kv-detail-container form.form-vertical', 10);
$I->makeScreenshot('success-pages-root-node');

$I->amGoingTo("Add a node");
$I->click('.kv-toolbar-container .kv-create');
$I->waitForElementVisible('#tree-name', 10);
$I->fillField('#tree-name', $uniqId);
$I->click('Save');
$I->waitForText($uniqId, 10, '.kv-tree');
$I->makeScreenshot('success-pages-add-node');