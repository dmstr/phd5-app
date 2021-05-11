<?php
/**
 * @group mandatory
 * @group backend
 */
class AccessControlUiCest
{

    public function testAccessControlUi(FunctionalTester $I)
    {
        $I->wantTo('ensure that access control UI works');

        $I->amOnPage('/');
        $I->dontSeeLink('/en/backend', '.nav');
        $I->dontSee('master');

        $I->login('master', 'master1');

        $I->see('master');
    }
}
