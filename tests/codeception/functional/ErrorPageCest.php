<?php


class ErrorPageCest
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
        $I->wantTo('ensure that error page works');

        $I->amOnPage('/_this_page_does_not_exist_');
        $I->seeResponseCodeIs(404);
        $I->see('Not Found');
    }
}
