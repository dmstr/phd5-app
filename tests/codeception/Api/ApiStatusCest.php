<?php

declare(strict_types=1);

namespace Api;

use \ApiTester;
use Codeception\Util\HttpCode;

final class ApiStatusCest
{
    public function _before(ApiTester $I): void
    {
        // Code here will be executed before each test.
    }

    public function testStatus(ApiTester $I): void
    {
        // Send a GET request to the API endpoint
        $I->sendGET('/static/status.json');

        // Check the response status code
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }
}
