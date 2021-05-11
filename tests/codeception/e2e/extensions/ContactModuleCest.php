<?php

/**
 * @group mandatory
 * @group contact-module
 */
class ContactModuleCest
{
    public function access(E2eTester $I)
    {
        $I->wantToTest('if the contact page is reachable and throws corresponding errors');

        $I->amOnPage('/contact/default/index');
        $I->waitForElementVisible('.wrap');
        $I->dontSee('404'); // check if site is reachable
        $I->see('400'); // check if schema parameter is required
    }
}
