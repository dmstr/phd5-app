<?php
/**
 * @group mandatory
 * @group widgets-module
 */
class WidgetsModuleTemplateCest
{

    public function tryToTest(E2eTester $I)
    {
        $I->wantTo('ensure that widgets-module works');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');


        $I->amGoingTo('check widget-templates');

        $I->amOnPage('/widgets/crud/widget-template/create');
        $I->waitForElement('form');
        $I->see('Create', 'button');
        $I->makeScreenshot('widget-templates');
    }
}
