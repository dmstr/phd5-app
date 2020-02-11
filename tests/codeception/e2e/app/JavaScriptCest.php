<?php
/**
 * @group mandatory
 */
class JavaScriptCest
{
    public function _before(E2eTester $I)
    {
    }

    public function _after(E2eTester $I)
    {
    }

    // tests
    public function testJavaScript(E2eTester $I)
    {
        $I->wantTo('ensure that JavaScript works');

        $I->amGoingTo('check javascript with a modal');

        $I->amOnPage('/en');
        $I->dontSee('#phd-info-panel');
        $I->dontSee('App Version');
        $I->dontSee('Project Version');

        $I->login('editor', 'editor1');

        $I->amGoingTo('hide the info button');
        $I->pressKey("body", "h");
        $I->dontSee('#phd-info-button a');

        $I->amGoingTo('show the info button');
        $I->pressKey("body", "h");
        $I->waitForElementVisible('#phd-info-button',10);
        $I->moveMouseOver('#phd-info-button');
        $I->click('#phd-info-button a[data-target="#phd-info-modal"]');
        $I->waitForElementVisible('#phd-info-modal',10);
        $I->seeElement('#phd-info-modal');
        $I->makeScreenshot('modal');

        $I->click('#phd-info-modal .close');
        $I->dontSee('#phd-info-modal');
    }
}
