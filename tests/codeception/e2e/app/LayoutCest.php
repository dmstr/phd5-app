<?php
/**
 * @group mandatory
 */
class LayoutCest
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
        $I->wantTo('ensure that there is no horizontal scrollbar');

        $I->amOnPage('/');

        $I->assertFalse(
            $I->executeJS("return document.getElementsByTagName(\"html\")[0].scrollWidth > document.getElementsByTagName(\"html\")[0].clientWidth"),
            'Horizontal scrollbar'
        );

        $I->makeScreenshot('home-no-scrollbars');
    }
}
