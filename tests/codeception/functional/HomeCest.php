<?php
/**
 * @group optional
 * @group frontend
 */
class HomeCest
{

    public function tesHomePage(FunctionalTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage('/site/index');
        $I->seeElement('html');
        $I->seeResponseCodeIs(200);

        $I->seeLink('Login');
    }
}
