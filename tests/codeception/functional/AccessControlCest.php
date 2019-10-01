<?php
/**
 * @group mandatory
 */
class AccessControlCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function testAccessControl(FunctionalTester $I)
    {
        $I->wantTo('ensure that access control works');

        $routesWithAccessControl = [
            '/backend',
            '/backend/default/view-config',
            '/prototype',
            '/prototype/html',
            '/prototype/less',
            '/prototype/less/create',
            '/settings',
            '/settings/default/create',
            '/translatemanager',
            '/user',
            '/pages'
        ];

        foreach ($routesWithAccessControl AS $route) {
            $I->amOnPage($route);
            $I->canSeeCurrentUrlMatches('|user/login|');
        }

    }
}
