<?php

// @group mandatory

$redirectId = '__test-redirect';

$I = new E2eTester($scenario);
$I->wantTo("ensure that 'redirects' module works");

$I->amGoingTo('try to login with correct credentials');

$I->login('preview', 'preview1');
$I->amGoingTo('test the redirect');
$I->amOnPage('/'.$redirectId);
$I->wait(1);

$I->seeInCurrentUrl('/user');
$I->see('preview', 'h4');

$I->makeScreenshot('after-redirect');
