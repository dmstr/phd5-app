<?php

/**
 * @group mandatory
 * @group user-module
 */
class UserPasswordRecoveryCest
{

    public function tryToTest(E2eTester $I)
    {
        $I->wantTo('ensure that password recovery works');

        $I->amOnPage('/user/security/login');
        $I->click('p > a');

        $I->fillField('#resendform-email', getenv('APP_ADMIN_EMAIL'));

        $I->click('button[type="submit"]');
    }
}
