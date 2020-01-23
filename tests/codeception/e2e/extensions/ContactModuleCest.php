<?php namespace extensions;

use E2eTester;

/**
 * @group mandatory
 */
class ContactModuleCest
{
    public function access(E2eTester $I)
    {
        $I->wantToTest('if the contact page is reachable and throws corresponding errors');

        $I->amOnPage('/contact/default/index');
        $I->waitForElementVisible('.wrap');
        $I->dontSee('Not Found (#404)'); // check if site is reachable
        $I->see('Bad Request (#400)'); // check if schema parameter is required
    }
}
