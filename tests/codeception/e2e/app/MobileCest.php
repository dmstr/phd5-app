<?php
/**
 * @group mandatory
 * @group frontend
 * @group mobile
 */
class MobileCest
{

    public function testMobileLayout(E2eTester $I)
    {
        $I->wantTo('ensure that responsive mobile layout works');

        $I->resizeWindow(320, 568);
        $I->amOnPage('/user/security/login');
        $I->makeScreenshot('mobile');

        $I->click('button.navbar-toggle');
        $I->waitForElementVisible('#link-login');

        $I->seeElement('li.active');
        $I->seeElement('#link-login');
        $I->makeScreenshot('mobile-open-menu');
    }
}
