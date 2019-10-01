<?php
/**
 * @group optional
 */
class LogoutFrontendCest
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
        $I->wantTo('ensure that logout from frontend works');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');
        $I->makeScreenshot('login-success');

        $I->expectTo('see user info');
        $I->click('.nav #link-user-menu a');

        $I->amOnPage('/');
        $I->click('.dropdown-toggle', '#link-user-menu');
        $I->waitForElementVisible('a#link-logout');
        $I->click('a#link-logout', '#link-user-menu');

        $I->dontSee('admin');
        $I->dontSee('master');
    }
}
