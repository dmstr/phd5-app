<?php
/**
 * @group mandatory
 */
use Faker\Factory;

class UserPasswordRecoveryCest
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

        $I->wantTo('ensure that password recovery works');

        $I->amOnPage('/user/login');
        $I->click('p > a');

        $I->fillField('#resendform-email', getenv('APP_ADMIN_EMAIL'));

        $I->click('button[type="submit"]');
    }
}
