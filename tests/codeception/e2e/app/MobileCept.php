<?php

// @group mandatory

$I = new E2eTester($scenario);

$I->wantTo('ensure that responsive mobile layout works');

$I->resizeWindow(320, 568);
$I->amOnPage('/');
$I->makeScreenshot('mobile');

$I->click('button.navbar-toggle');
$I->waitForElementVisible('#link-login');

$I->seeElement('li.active');
$I->seeElement('#link-login');
$I->makeScreenshot('mobile-open-menu');
