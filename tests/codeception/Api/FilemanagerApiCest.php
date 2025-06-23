<?php

declare(strict_types=1);

namespace Api;

use ApiTester;
use Codeception\Util\HttpCode;
use Yii;

final class FilemanagerApiCest
{
    public function _before(ApiTester $I): void
    {
        $jwt = YII::$app->jwt;

        $token = $jwt->getBuilder()
            ->issuedBy('test-app')
            ->permittedFor('test-api')
            ->issuedAt(\DateTimeImmutable::createFromTimestamp(time()))
            ->expiresAt(\DateTimeImmutable::createFromTimestamp(time() + 3600)) // 1 hour
            ->relatedTo('1')
            ->getToken($jwt->getConfiguration()->signer(), $jwt->getConfiguration()->signingKey());

        $I->amBearerAuthenticated($token->toString());
    }

    public function testFilemanagerApiResponseWithWrongId(ApiTester $I): void {
        $I->amGoingTo( 'Check the response status code with wrong id');

        $jwt = YII::$app->jwt;

        $token = $jwt->getBuilder()
            ->issuedBy('test-app')
            ->permittedFor('test-api')
            ->issuedAt(\DateTimeImmutable::createFromTimestamp(time()))
            ->expiresAt(\DateTimeImmutable::createFromTimestamp(time() + 3600)) // 1 hour
            ->relatedTo('10')
            ->getToken($jwt->getConfiguration()->signer(), $jwt->getConfiguration()->signingKey());

        $I->amBearerAuthenticated($token->toString());
        $I->sendGET('/filemanager/api/list', ["path" => "/"]);

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED); // 401
    }

    public function testFilemanagerGetFolder(ApiTester $I): void {
        $I->amGoingTo( 'try to get folder list');

        $I->sendGET('/filemanager/api/list', ["path" => "/"]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["path" => "/"]);
        $I->seeResponseContainsJson(["storageId" => "fsLocal"]);
        $I->seeResponseContainsJson(["name" => "public"]);
        $I->seeResponseContainsJson(["fullPath" => "/public"]);
        $I->seeResponseContainsJson(["type" => "dir"]);
        $I->seeResponseContainsJson(["size" => null]);
        $I->seeResponseContainsJson(["lastModified" => false]);
        $I->seeResponseContainsJson(["permissions" => ["permission_owner" => "1"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_owner_grant" => "15"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_group_grant" => "15"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_group_name" => "FilemanagerEditor"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_other_grant" => "1"]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["read" => true]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["write" => true]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["delete" => true]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["canChangePermissions" => true]]);
    }

    public function testCreateTestDirectory(ApiTester $I): void {
        $I->amGoingTo('create a directory called Ttest');

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => 'Ttest'
        ]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/Ttest"]);
        $I->seeResponseContainsJson(["message" => ""]);
    }
}
