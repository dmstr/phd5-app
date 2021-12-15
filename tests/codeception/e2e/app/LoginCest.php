<?php
/**
 * @group mandatory
 * @group frontend
 */
class LoginCest
{

    public function ensureLogin(E2eTester $I)
    {
        $I->wantTo('ensure that login works');

        $I->amGoingTo('try to login with empty credentials');
        $I->login('', '', false);
        $I->expectTo('see validations errors');
        $I->waitForText('Login cannot be blank.');
        $I->see('Password cannot be blank.');

        $I->amGoingTo('try to login with wrong credentials');
        $I->login('admin', 'wrong', false);
        $I->wait(1);
        $I->expectTo('see validations errors');
        $I->see('Invalid login or password');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');
        $I->makeScreenshot('login-success');

        $I->amOnPage('/backend');

        $I->expectTo('see backend elements');
        $I->see('master');
        $I->click('[data-toggle="control-sidebar"]');
        $I->wait(0.5);
        $I->click('a[href="#control-sidebar-modules-tab"]');
        $I->wait(0.5);
        $I->see('Application Modules', 'h3');
        $I->see('Widget Content','h4');
        $I->see('Page Tree','h4');
        $I->see('Settings','h4');
        $I->see('Audit','h4');
        $I->see('Jobs','h4');
        $I->see('filefly','a');
        $I->see('redirects','a');

        $I->amOnPage('/site/index');
        $I->expectTo('see user info');
        $I->click('.nav #link-user-menu a');

        $I->seeElement('#link-logout');
        $I->click('#link-logout');
        $I->waitForElementNotVisible('#link-logout');

        $I->dontSee('405', 'h1');
        $I->seeElement('#link-login');

        $I->makeScreenshot('logout-success');
    }

    public function testLogin(E2eTester $I)
    {
        $I->wantTo('ensure that login works');

        $I->amGoingTo('try to login with correct credentials');
        $I->login('master', 'master1');
        $I->makeScreenshot('login-success');

        $I->expectTo('see user info');
        $I->click('.nav #link-user-menu a');

        $I->seeElement('#link-logout');
        $I->click('#link-logout');
        $I->waitForElementNotVisible('#link-logout');

        $I->dontSee('405', 'h1');
        $I->seeElement('#link-login');

        $I->makeScreenshot('logout-success');
    }
}
