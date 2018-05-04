<?php

// @group mandatory
// @group base-test-setup

$I = new E2eTester($scenario);

$I->wantTo('ensure that preview access works');

$I->amOnPage('/');
$I->makeScreenshot('debug-preview-access-login');

$I->amGoingTo('try to login as preview');
$I->login('preview', 'preview1');

$I->expect('not to see an inactive widget');
$I->amOnPage('/ru');
$I->dontSeeElement('#cell-main .hrzg-widget-widget');
$I->dontSeeHorizontalScrollbars();

$I->amOnPage('/de');
$I->dontSee('.alert');
$I->dontSee('Sign in');
$I->canSee('Demo','h1');
$I->dontSeeHorizontalScrollbars();

$I->click('Beispielseite A');
$I->dontSee('.alert');
$I->dontSeeHorizontalScrollbars();

$I->makeScreenshot('success-preview-access');

