<?php

declare(strict_types=1);

namespace Api;

use ApiTester;
use bizley\jwt\Jwt;
use Codeception\Util\HttpCode;

final class FilemanagerApiCest
{
    public function _before(ApiTester $I): void
    {
        // Code here will be executed before each test.
    }

    public function testFilemanagerGetFolder(ApiTester $I): void {
        $I->amGoingTo( 'try to get folder list');
        
        // Create a simple JWT component for testing
        $jwt = new Jwt([
            'signer' => Jwt::HS256,
            'signingKey' => 'test-secret-key-for-testing-only'
        ]);
        
        $token = $jwt->getBuilder()
            ->issuedBy('test-app')
            ->permittedFor('test-api')
            ->issuedAt(\DateTimeImmutable::createFromTimestamp(time()))
            ->expiresAt(\DateTimeImmutable::createFromTimestamp(time() + 3600)) // 1 hour
            ->withClaim('uid', 1) // user ID
            ->getToken($jwt->getConfiguration()->signer(), $jwt->getConfiguration()->signingKey());
        
        $I->amBearerAuthenticated($token->toString());
        $I->sendGET('/filemanager/api/list', ["path" => "/"]);

        // Check the response status code
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }
}
