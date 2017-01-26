<?php

// @group mandatory

$I = new E2eTester($scenario);

$I->wantTo('ensure that JavaScript works');

$I->amGoingTo('check javascript with a modal');

$I->amOnPage('/en');
$I->dontSee('#infoModal');

$I->click('.phd-info a');
$I->waitForElementVisible('#infoModal',3);
$I->seeElement('#infoModal');
$I->makeScreenshot('modal');

$I->click('#infoModal .close');
$I->dontSee('#infoModal');
