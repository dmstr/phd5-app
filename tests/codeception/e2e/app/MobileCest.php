<?php
/**
 * @group mandatory
 */
class MobileCest
{
    public function _before(E2eTester $I)
    {
    }

    public function _after(E2eTester $I)
    {
    }

    // tests
    public function testMobileLayout(E2eTester $I)
    {
        $I->wantTo('ensure that responsive mobile layout works');

        $I->resizeWindow(320, 568);
        $I->amOnPage('/');
        $I->makeScreenshot('mobile');

        $I->click('button.navbar-toggle');
        $I->waitForElementVisible('#link-login');

        $I->seeElement('li.active');
        $I->seeElement('#link-login');
        $I->makeScreenshot('mobile-open-menu');
    }
}
