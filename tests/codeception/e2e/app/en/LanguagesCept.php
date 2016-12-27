<?php

// @group mandatory

$I = new E2eTester($scenario);

$I->wantTo('ensure that language urls and redirects work');

$I->amOnPage('/');
$I->seeCurrentUrlEquals('/en/user/login');

$I->amOnPage('/xx');
$I->seeElement('.site-error');

$I->amOnPage('/de');
$I->seeCurrentUrlEquals('/de/user/login');
$I->see('Anmelden');
$I->makeScreenshot('language-de');

$I->amOnPage('/en-us');
$I->see('Not Found');
