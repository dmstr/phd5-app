<?php

// @group mandatory

use Faker\Factory;

$faker = Factory::create();
$username = $faker->userName;

$I = new E2eTester($scenario);
$I->wantTo('ensure that User module works');

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');

$I->amGoingTo('try to view and create snippets');
$I->amOnPage('/user/admin/create');

$I->fillField('#user-email', $faker->email);
$I->fillField('#user-username', $username);
$I->fillField('#user-password', $faker->password);

$I->click('button[type="submit"]');

$I->waitForText('Success', 5);
$I->seeInFormFields('form', ['User[username]'=>$username]);

$I->pauseExecution();