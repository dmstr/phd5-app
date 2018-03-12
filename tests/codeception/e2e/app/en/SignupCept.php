<?php

// @group mandatory

$I = new E2eTester($scenario);
$I->wantTo('ensure that sign-up works according to APP_USER_ENABLE_REGISTRATION setting');
$enableRegistration = getenv('APP_USER_ENABLE_REGISTRATION');

if ( $enableRegistration == 1 ) {
    $I->expect('sign-up is enabled');
    $I->amOnPage('/user/login');
    $I->seeLink("Don't have an account? Sign up!", '/en/user/register');
    $I->amOnPage('/user/register');
    $I->see('Sign up');

} else {
    $I->expect('sign-up is NOT enabled');
    $I->amOnPage('/user/login');
    $I->dontSeeLink("Don't have an account? Sign up!", '/en/user/register');
    $I->amOnPage('/user/register');
    #$I->$I->seeResponseCodeIs(404);
    $I->see('Not Found (#404)');
}
