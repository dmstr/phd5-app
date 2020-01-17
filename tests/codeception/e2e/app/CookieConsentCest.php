<?php
/**
 * @group mandatory
 */

class CookieConsentCest
{
    public function _before(E2eTester $I)
    {
    }

    public function _after(E2eTester $I)
    {
    }

    // tests
    public function cookieConsent(E2eTester $I)
    {
        $I->wantTo('ensure that Cookie Consent initial state is correct');
        $I->login('master', 'master1');
        $I->amOnPage('/test/consent');
        $I->waitForElementVisible('.cookie-consent-popup', 5);
        $I->waitForElementVisible('.cookie-consent-accept-all', 5);
        $I->waitForElementVisible('.cookie-consent-controls-toggle', 5);
        $I->waitForElementVisible('.cookie-consent-details-toggle', 5);
        $I->dontSee('.cookie-consent-controls');
        $I->dontSee('.cookie-consent-details');
        $I->dontSee('necessary cookies enabled');
        $I->dontSee('statistics cookies enabled');
        $I->dontSeeCookie('cookie_consent_status');

        $I->wantTo('ensure that Cookie Consent controls and details can be toggled');
        $I->click('.cookie-consent-details-toggle');
        $I->waitForElementVisible('.cookie-consent-details', 5);
        $I->click('.cookie-consent-controls-toggle');
        $I->waitForElementVisible('.cookie-consent-controls', 5);
        $I->pauseExecution();

        $I->waitForElementVisible('.cookie-consent-save', 5);
        $I->click('.cookie-consent-save');

        $I->wantTo('give consent to only necessary cookies');
        $I->waitForElementVisible('.necessary-cookies-enabled', 5);
        $I->dontSee('statistics cookies enabled');
        $I->seeCookie('cookie_consent_status');

        $I->wantTo('give consent for all cookies');
        $I->click('.cookie-consent-toggle');
        $I->click('.cookie-consent-accept-all');
        $I->waitForElementVisible('.necessary-cookies-enabled', 5);
        $I->waitForElementVisible('.statistics-cookies-enabled', 5);
        $I->seeCookie('cookie_consent_status');

        $I->wantTo('navigate to privacy page from cookie consent link');
        $I->click('.cookie-consent-toggle');
        $I->click('.cookie-consent-link');
        $I->waitForElementVisible('.privacy-view', 5);
    }
}
