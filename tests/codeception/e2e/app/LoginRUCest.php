<?php

class LoginRUCest
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
        $I->wantTo('ensure that login works');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');
        $I->makeScreenshot('login-success');

        $I->expectTo('see user info');
        $I->click('.nav #link-user-menu a');
#$i->wait(1);

        $I->seeElement('#link-logout');
        $I->click('#link-logout');
        $I->waitForElementNotVisible('#link-logout');

        $I->dontSee('405', 'h1');
        $I->seeElement('#link-login');

        $I->makeScreenshot('logout-success');
    }
}
