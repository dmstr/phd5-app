<?php
/**
 * @group mandatory
 * @group base-test-setup
 */
class EditorAccessCest
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
        $I->wantTo('ensure that preview access works');

        $I->amOnPage('/');
        $I->makeScreenshot('debug-preview-access-login');

        $I->amGoingTo('try to login as preview');
        $I->login('preview', 'preview1');

        $I->expect('not to see an inactive widget');
        $I->amOnPage('/ru');
        $I->dontSeeElement('#cell-main .hrzg-widget-widget');
        $I->dontSeeHorizontalScrollbars();

        $I->amOnPage('/de');
        $I->dontSee('.alert');
        $I->dontSee('Sign in');
        $I->canSee('Demo','h1');
        $I->dontSeeHorizontalScrollbars();

        $I->click('Beispielseite A');
        $I->dontSee('.alert');
        $I->dontSeeHorizontalScrollbars();

        $I->makeScreenshot('success-preview-access');
    }
}
