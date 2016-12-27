<?php

// @group mandatory

$I = new E2eTester($scenario);

$I->wantTo('ensure that home page is not visible without login');

$I->amOnPage('/');
$I->see('Sign in', '.panel.panel-default');
$I->seeElement('#link-login');

$I->makeScreenshot('home');
