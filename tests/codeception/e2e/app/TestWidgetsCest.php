<?php
/**
 * @group optional
 * @group frontend
 * @group widgets-module
 */
class TestWidgetsCest
{
    public function _before(E2eTester $I)
    {
    }

    public function _after(E2eTester $I)
    {
    }

    // tests
    public function testWidgets(E2eTester $I)
    {
        $I->wantTo('ensure that widgets-module works');


        $I->amGoingTo('try to login with correct credentials');

        $I->login('editor', 'editor1');


        $I->amGoingTo('try to view and create widgets');

        $I->amOnPage('/ru');
        $I->see('Aliquam tincidunt mauris', '#cell-main');
        $I->makeScreenshot('widgets');


        $I->expect('to see widget container(s)');

        $I->click('Test page index');
        $I->moveMouseOver('.hrzg-widget-widget-container');
        $I->makeScreenshot('widgets-frontend-container');


        $I->amGoingTo('edit  a widget from a container');

        $I->comment('Mouse-over first container');
        $I->moveMouseOver('#cell-header.hrzg-widget-widget-container');
        $I->waitForElementVisible('#cell-header .hrzg-widget-container-controls .btn-success');
        $I->click('#cell-header .hrzg-widget-container-controls .btn-success');
        $I->waitForElementVisible('.widget-create');


        $I->amGoingTo('select a widget');

        $I->selectOption('#widgetcontent-widget_template_id', 'Content');
        $I->waitForElementVisible('#widgetcontent-default_properties_json-container .well');


        $I->wantTo('ensure pre-filled values still exist');

        $I->seeInField('#widgetcontent-route','widgets/test/index');
        $I->fillField('root[title]', 'This is a test.');
        $I->makeScreenshot('widgets-backend-create-1');
        $I->click('Create');
        $I->wait(3);
        $I->see('This is a test.', 'h2');
    }
}
