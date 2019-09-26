<?php


class HomeCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage('/site/index');
        $I->seeElement('html');
        $I->seeResponseCodeIs(200);


        $I->seeLink('Login');
    }
}
