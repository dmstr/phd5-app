<?php


class AccessControlUICest
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
        $I->wantTo('ensure that access control UI works');

        $I->amOnPage('/');
        $I->dontSeeLink('/en/backend', '.nav');
        $I->dontSee('','.glyphicon.glyphicon-cog');

        $I->login('master', 'master1');

        $I->see('','.glyphicon.glyphicon-cog');
    }
}
