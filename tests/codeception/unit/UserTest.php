<?php


use Codeception\Test\Unit;
use Da\User\Model\User;

/**
 * @group user-module
 */
class UserTest extends Unit
{
    public function testUserLoginLogout()
    {
        $identity = User::findIdentity(1);
        $this->assertTrue(\Yii::$app->user->login($identity, 0));
        $this->assertTrue(\Yii::$app->user->logout());
    }

    public function testNonExistingUserModel()
    {
        $identity = User::findIdentity(99999);
        $this->assertNull($identity);
    }
}
