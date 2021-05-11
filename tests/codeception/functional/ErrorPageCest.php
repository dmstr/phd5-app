<?php
/**
 * @group mandatory
 * @group frontend
 */
class ErrorPageCest
{

    public function testErrorPage(FunctionalTester $I)
    {
        $I->wantTo('ensure that error page works');

        $I->amOnPage('/_this_page_does_not_exist_');
        $I->seeResponseCodeIs(404);
    }
}
