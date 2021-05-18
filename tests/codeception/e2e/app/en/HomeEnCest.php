<?php
/**
 * @group mandatory
 * @group frontend
 */
class HomeEnCest
{

    public function tryToTest(E2eTester $I)
    {
        $I->wantTo('ensure that home page is not visible without login');

        $I->amOnPage('/');
        $I->see('Sign in', '.panel.panel-default');
        $I->seeElement('#link-login');

        $I->makeScreenshot('home');
    }
}
