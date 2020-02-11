<?php

namespace extensions;


use E2eTester;

/**
 * @package extensions
 * @author Elias Luhr <e.luhr@herzogkommunikation.de>
 *
 * @group mandatory
 */
class RedirectsCest
{

    private $_test_redirect;

    public function _before(E2eTester $I)
    {
        if (empty($this->_test_redirect)) {
            $this->_test_redirect = dechex(time());
        }
    }

    /**
     * @param E2eTester $I
     *
     * @throws \Exception
     */
    public function backend(E2eTester $I)
    {
        $I->wantTo("ensure that 'redirects' module works");

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');

        $I->amOnPage('/redirects');
        $I->click('New');

        $I->waitForElementVisible('.redirect-form');
        $I->selectOption('Redirect[type]', 'Path redirect');
        $I->fillField('Redirect[from_path]', '/' . $this->_test_redirect);
        $I->fillField('Redirect[to_path]', '/site/index');
        $I->selectOption('#redirect-status_code input', 301);
        $I->click('Create');

        $I->waitForElementNotVisible('.redirect-form');
        $I->see($this->_test_redirect, 'table');

        $I->makeScreenshot('redirect-create');

    }

    /**
     * @param E2eTester $I
     *
     * @throws \Exception
     */
    public function frontend(E2eTester $I)
    {
        $I->wantTo("ensure that 'redirects' module works");

        $I->amGoingTo('try to login with correct credentials');

        $I->login('preview', 'preview1');
        $I->amGoingTo('test the redirect');
        $I->amOnPage('/' . $this->_test_redirect);
        $I->seeInCurrentUrl('/site/index');
        $I->waitForElementVisible('.site-index');

        $I->makeScreenshot('after-redirect');

    }
}
