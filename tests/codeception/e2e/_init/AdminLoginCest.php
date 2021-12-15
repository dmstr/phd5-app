<?php

/**
 * @group mandatory
 */
class AdminLoginCest
{

    public function loginAsMaster(E2eTester $I)
    {
        $I->wantTo('login as master');

        $I->amGoingTo('try to login as master');
        $I->login('master', 'master1');

        $I->see('master','#link-user-menu');
        $I->makeScreenshot('admin-login-frontend');
    }
}
