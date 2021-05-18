<?php

use Faker\Factory;

/**
 * @group mandatory
 * @group user-module
 */
class UserCreateCest
{

    public function tryToTest(E2eTester $I)
    {
        $faker = Factory::create();
        $username = $faker->userName;

        $I->wantTo('ensure that User module works');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');

        $I->amGoingTo('try to view and create snippets');
        $I->amOnPage('/user/admin/create');

        $I->fillField('#user-email', $faker->email);
        $I->fillField('#user-username', $username);
        $I->fillField('#user-password', $faker->password);

        $I->click('button[type="submit"]');

        $I->waitForText('Success');
        $I->seeInFormFields('form', ['User[username]' => $username]);

        $I->pauseExecution();
    }
}
