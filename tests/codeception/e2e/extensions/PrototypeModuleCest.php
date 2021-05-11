<?php
/**
 * @group mandatory
 * @group prototype-module
 */
class PrototypeModuleCest
{

    public function tryToTest(E2eTester $I)
    {
        $I->wantTo('ensure that Prototype works');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');

        $I->amGoingTo('try to view and create snippets');
        $I->amOnPage('/prototype');

        $I->amOnPage('/prototype/less/create');
        $I->waitForElementVisible('.giiant-crud button[type="submit"]');
        $I->canSee('Create', 'button');

        $I->amOnPage('/prototype/twig/create');
        $I->waitForElementVisible('.giiant-crud button[type="submit"]');
        $I->canSee('Create', 'button');

        $I->amOnPage('/prototype/html/create');
        $I->waitForElementVisible('.giiant-crud button[type="submit"]');
        $I->canSee('Create', 'button');
    }
}
