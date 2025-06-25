<?php

declare(strict_types=1);

namespace Api;

use ApiTester;
use Codeception\Util\HttpCode;
use Yii;

final class FilemanagerApiCest {
    public function _before(ApiTester $I): void {
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
        $I->amGoingTo( 'check the response status code with wrong id');

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

    /**
     * @param ApiTester $I
     * @return void
     * @depends testFilemanagerApiResponseWithWrongId
     */
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

    /**
     * @param ApiTester $I
     * @return void
     * @depends testFilemanagerGetFolder
     */
    public function testCreateTestDirectory(ApiTester $I): void {
        $I->amGoingTo('create a directory called test-1');

        $I->sendGET('/filemanager/api/list', ['path' => '/']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
//        print_r($I->grabResponse());
//        print_r(str_contains($I->grabResponse(), "test-1"));
        if (str_contains($I->grabResponse(), "test-1")) {
            $I->sendDELETE('/filemanager/api/delete-directory?path=/test-1');
        }

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => 'test-1'
        ]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/test-1"]);
        $I->seeResponseContainsJson(["message" => ""]);
    }

    /**
     * @param ApiTester $I
     * @return void
     * @depends testCreateTestDirectory
     */
    public function testGetTestDirectory(ApiTester $I): void {
        $I->amGoingTo('get a directory called test-1');

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["name" => "test-1"]);
        $I->seeResponseContainsJson(["fullPath" => "/test-1"]);
    }

    /**
     * @param ApiTester $I
     * @return void
     * @depends testGetTestDirectory
     */
    public function testDeleteTestDirectory(ApiTester $I): void {
        $I->amGoingTo('delete a directory called test-1');

        $I->sendDELETE('/filemanager/api/delete-directory?path=/test-1');

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(["success" => true]);
    }

    /**
     * @param ApiTester $I
     * @return void
     * @depends testDeleteTestDirectory
     */
    public function testNotGetTestDirectory(ApiTester $I): void {
        $I->amGoingTo('not get a directory called test#1');

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContainsJson(["name" => "test-1"]);
        $I->dontSeeResponseContainsJson(["fullPath" => "/test-1"]);
//        print_r($I->grabResponse());
    }

    /**
     * @param ApiTester $I
     * @return void
     * @depends testNotGetTestDirectory
     */
    public function testCreateDirectoryInDirectory(ApiTester $I): void {
        $I->amGoingTo('create a directory called test-1');

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => 'test-1'
        ]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/test-1"]);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/test-1',
            'name' => 'test-2'
        ]);

        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/test-1/test-2"]);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
//        print_r($I->grabResponse());
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["name" => "test-1"]);
        $I->seeResponseContainsJson(["fullPath" => "/test-1"]);

//        $I->seeResponseContainsJson(["name" => "test-1/test-2"]);
//        $I->seeResponseContainsJson(["fullPath" => "/test-1/test-2"]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/test-1');

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(["message" => "Directory is not empty and can not be deleted"]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/test-1/test-2');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(["success" => true]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/test-1');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(["success" => true]);
    }
}
