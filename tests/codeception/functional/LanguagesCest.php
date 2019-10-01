<?php
/**
 * @group mandatory
 * @group base-test-setup
 */
class LanguagesCest
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
        $I->wantTo('ensure that language urls work');

        $I->expect('a 404 error for a non-existant language');
        $I->amOnPage('/xx');
        $I->canSeeResponseCodeIs(404);

        $I->expect('a redirect if no language is set');
        $I->amOnPage('/');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/de');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/en');
        $I->canSeeResponseCodeIs(200);

// Note: extended redirect testing needs to be run in acceptance tests
    }
}
