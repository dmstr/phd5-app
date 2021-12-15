<?php

/**
 * @group mandatory
 * @group base-test-setup
 * @group frontend
 */
class PreviewAccessCest
{

    public function testPreviewAccess(E2eTester $I)
    {
        $I->wantTo('ensure that preview access works');

        $I->amOnPage('/site/index');
        $I->makeScreenshot('debug-preview-access-login');

        $I->amGoingTo('try to login as preview');
        $I->login('preview', 'preview1');

        $I->amOnPage('/en/site/index');
        $I->dontSeeHorizontalScrollbars();

        $I->amOnPage('/de/site/index');
        $I->dontSee('.alert');
        $I->dontSee('Sign in');
        $I->canSee('Demo','h1');
        $I->dontSeeHorizontalScrollbars();

        $I->click('Beispielseite A');
        $I->dontSee('.alert');
        $I->dontSeeHorizontalScrollbars();

        $I->expect('not to see admin/editor elements');
        $I->dontSeeElement('.nav-extra *');
        $I->dontSeeElement('.nav-backend');

        $I->makeScreenshot('success-preview-access');
    }
}
