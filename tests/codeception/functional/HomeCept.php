<?php

// @group optional

$I = new FunctionalTester($scenario);

$I->wantTo('ensure that home page works');
$I->amOnPage('/site/index');
$I->seeElement('html');
$I->seeResponseCodeIs(200);


$I->seeLink('Login');