<?php
/**
 * @group mandatory
 * @group base-test-setup
 * @group frontend
 */
class LanguagesEnCest
{
    public function _before(E2eTester $I)
    {
    }

    public function _after(E2eTester $I)
    {
    }

    // tests
    public function testLanguageUrls(E2eTester $I)
    {
        $I->wantTo('ensure that language urls and redirects work');

        $I->amOnPage('/site/index');
        $I->seeCurrentUrlEquals('/en/user/login');

        $I->amOnPage('/de/site/index');
        $I->seeCurrentUrlEquals('/de/user/login');
        $I->see('Anmelden');
        $I->makeScreenshot('language-de');

        $I->amOnPage('/xx');
        $I->seeElement('.site-error');

        $I->amOnPage('/en-us');
        $I->see('Not Found');
    }
}
