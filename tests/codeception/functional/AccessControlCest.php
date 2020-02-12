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

    /**
     * @example ["/backend"]
     * @example ["/backend/default/view-config"]
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
