<?php
/**
 * @group mandatory
 * @group frontend
 */
class LoginFunctionalCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function testLogin(FunctionalTester $I)
    {
        $I->wantTo('ensure that login works');

#$I->see('Sign In', 'h3');

        $I->amGoingTo('try to login with empty credentials');
        $I->login('', '');
        $I->expectTo('see validations errors');
        $I->see('Login cannot be blank.');
        $I->see('Password cannot be blank.');

        $I->amGoingTo('try to login with wrong credentials');
        $I->login('admin', 'wrong');
        $I->expectTo('see validations errors');
        $I->see('Invalid login or password');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');

        $I->amOnPage('/site');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/backend');
        $I->seeResponseCodeIs(200);

        $I->expectTo('see backend elements');
        $I->see('master');
        $I->see('Application Modules', 'h3');
        $I->see('Widget Content','h4');
        $I->see('Page Tree','h4');
        $I->see('Settings','h4');
        $I->see('Audit','h4');
        $I->see('Jobs','h4');
        $I->see('filefly','a');
        $I->see('redirects','a');

    }
}
