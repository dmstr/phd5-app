<?php

// @group mandatory

$I = new E2eTester($scenario);

$I->wantTo('ensure that home page is not visible without login');

$I->amOnPage('/');
$I->seeLink('Login');

$I->makeScreenshot('home');
