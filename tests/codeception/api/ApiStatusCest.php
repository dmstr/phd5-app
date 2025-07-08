<?php

declare(strict_types=1);

use Codeception\Util\HttpCode;

final class ApiStatusCest
{
    public function _before(ApiTester $I): void
    {
        // Code here will be executed before each test.
    }

    public function testStatus(ApiTester $I): void
    {
        $I->amGoingTo('check status');

        $I->sendGET('/static/status.json');

        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
