<?php

use Faker\Factory;

class UserCreateCest
{
    public function _before(E2eTester $I)
    {
    }

    public function _after(E2eTester $I)
    {
    }

    // tests
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

        $I->waitForText('Success', 10);
        $I->seeInFormFields('form', ['User[username]'=>$username]);

        $I->pauseExecution();
    }
}
