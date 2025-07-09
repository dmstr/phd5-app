<?php

declare(strict_types=1);

use Codeception\Util\HttpCode;


/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    /**
     * Define custom actions here
     */
    public function authenticate($username, $password)
    {
        $this->sendPost('/user/api/v1/security/login', ['login' => $username, 'password' => $password]);
        $this->seeResponseCodeIs(HttpCode::OK);
        $this->seeResponseIsJson();
        $token = $this->grabDataFromResponseByJsonPath('$.token')[0] ?? '';
        $this->amBearerAuthenticated($token);
    }
}
