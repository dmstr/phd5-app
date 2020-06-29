<?php
/**
 * @group mandatory
 * @group backend
 */
class AccessControlCest
{
    /**
     * Non-public routes
     *
     * @example ["/backend"]
     * @example ["/backend/config/view"]
     * @example ["/prototype"]
     * @example ["/prototype/html"]
     * @example ["/prototype/less"]
     * @example ["/prototype/less/create"]
     * @example ["/settings"]
     * @example ["/settings/default/create"]
     * @example ["/translatemanager"]
     * @example ["/user"]
     * @example ["/pages"]
     * @example ["/resque"]
     * @example ["/audit"]
     */
    public function testAccessControl(FunctionalTester $I, \Codeception\Example $example)
    {
        $I->wantTo('ensure that access control works');
         $I->amOnPage($example[0]);
            $I->canSeeCurrentUrlMatches('|user/login|');

    }
}
