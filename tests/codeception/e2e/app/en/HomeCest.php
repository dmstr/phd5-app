<?php

class HomeCest
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
        $I->wantTo('ensure that home page is not visible without login');

        $I->amOnPage('/');
        $I->see('Sign in', '.panel.panel-default');
        $I->seeElement('#link-login');

        $I->makeScreenshot('home');
    }
}
