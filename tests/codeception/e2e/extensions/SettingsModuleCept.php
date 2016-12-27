<?php

// @group mandatory


$I = new E2eTester($scenario);

$I->amOnPage('/settings');
$I->dontSee('Settings', 'h1');

$I->login('admin', 'admin1');

$I->amOnPage('/settings');
$I->see('Settings', 'h1');
$I->makeScreenshot('settings');