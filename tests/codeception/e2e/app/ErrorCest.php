<?php

/**
 * Class ErrorCest
 * @package fitter
 * @group optional
 */
class ErrorCest
{
    public function _before(\E2eTester $I)
    {
    }

    public function _after(\E2eTester $I)
    {
    }

    // tests
    public function errorPage(\E2eTester $I)
    {
        $I->amOnPage('NON_EXISTENT_PAGE');
        $I->see('Fehler 404');
    }
}
