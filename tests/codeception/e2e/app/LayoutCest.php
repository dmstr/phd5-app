<?php
/**
 * @group mandatory
 * @group frontend
 */
class LayoutCest
{

    public function testLayout(E2eTester $I)
    {
        $I->wantTo('ensure that there is no horizontal scrollbar');

        $I->amOnPage('/');
        $I->waitForElement('.nav');

        $I->assertFalse(
            $I->executeJS("return document.getElementsByTagName(\"html\")[0].scrollWidth > document.getElementsByTagName(\"html\")[0].clientWidth"),
            'Horizontal scrollbar'
        );

        $I->makeScreenshot('home-no-scrollbars');
    }
}
