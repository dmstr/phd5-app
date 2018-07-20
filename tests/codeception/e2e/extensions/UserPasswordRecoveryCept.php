<?php

// @group mandatory

use Faker\Factory;

$faker = Factory::create();
$username = $faker->userName;

$I = new E2eTester($scenario);
$I->wantTo('ensure that password recovery works');

$I->amOnPage('/user/login');
$I->click('p > a');

$I->fillField('#resendform-email', getenv('APP_ADMIN_EMAIL'));

$I->click('button[type="submit"]');