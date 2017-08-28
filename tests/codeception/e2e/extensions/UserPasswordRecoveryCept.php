<?php

// @group mandatory

use Faker\Factory;

$faker = Factory::create();
$username = $faker->userName;

$I = new E2eTester($scenario);
$I->wantTo('ensure that password recovery works');

$I->amOnPage('/user/login');
$I->click('A', '.field-login-form-password');

$I->fillField('#recovery-form-email', getenv('APP_ADMIN_EMAIL'));

$I->click('button[type="submit"]');

$I->waitForText('An email has been sent with instructions for resetting your password', 5);

$I->pauseExecution();