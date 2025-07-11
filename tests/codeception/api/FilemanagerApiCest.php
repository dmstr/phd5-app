<?php

declare(strict_types=1);

use Codeception\Util\HttpCode;

/**
 * @group wip
*/
final class FilemanagerApiCest
{
    public function _before(ApiTester $I): void
    {
        $I->authenticate('admin', 'admin1');
    }

    public function testFilemanagerApiResponseWithWrongId(ApiTester $I): void
    {
        $I->amGoingTo('check the response status code with wrong id');

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
     *
     * @return void
     * @depends testFilemanagerApiResponseWithWrongId
     */
    public function testFilemanager(ApiTester $I): void
    {
        $dirName = uniqid("filemanagerapicest-test-folder-");

        $I->amGoingTo('try to get folder list');

        $I->sendGET('/filemanager/api/list', ["path" => "/"]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["path" => "/"]);
        $I->seeResponseContainsJson(["storageId" => "fsLocal"]);
        $I->seeResponseContainsJson(["size" => null]);
        $I->seeResponseContainsJson(["permissions" => ["permission_owner" => "1"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_owner_grant" => "15"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_group_grant" => "15"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_group_name" => "FilemanagerEditor"]]);
        $I->seeResponseContainsJson(["permissions" => ["permission_other_grant" => "1"]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["read" => true]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["write" => true]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["delete" => true]]);
        $I->seeResponseContainsJson(["guiPermissions" => ["canChangePermissions" => true]]);

        $I->amGoingTo('create a directory called ' . $dirName);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
//        print_r($I->grabResponse());
//        print_r(str_contains($I->grabResponse(), "test-1"));


        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);

        $I->seeResponseCodeIs(HttpCode::CREATED); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true, "message" => "created"]);

        $I->amGoingTo('get a directory called ' . $dirName);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains($dirName);
        $I->seeResponseContains("/" . $dirName);

        $I->amGoingTo('delete a directory called ' . $dirName);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $dirName);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(["success" => true]);

        $I->amGoingTo('not get a directory called ' . $dirName);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContainsJson(["name" => $dirName]);
        $I->dontSeeResponseContainsJson(["fullPath" => "/" . $dirName]);
//        print_r($I->grabResponse());

        $I->amGoingTo('create a directory called ' . $dirName);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);

        $I->seeResponseCodeIs(HttpCode::CREATED); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true]);

        $I->amGoingTo('create a directory called ' . $dirName . "-2 inside the directory called " . $dirName);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $dirName,
            'name' => $dirName . "-2"
        ]);

        $I->seeResponseContainsJson(["success" => true, 'message' => 'created']);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
//        print_r($I->grabResponse());
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["name" => $dirName]);
        $I->seeResponseContainsJson(["fullPath" => "/" . $dirName]);

//        $I->seeResponseContainsJson(["name" => "test-1/test-2"]);
//        $I->seeResponseContainsJson(["fullPath" => "/test-1/test-2"]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $dirName);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson(["message" => "Directory is not empty and can not be deleted"]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $dirName . "/" . $dirName . "-2");;
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(["success" => true]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $dirName);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(["success" => true]);
    }

    public function testFilemanagerPersistenceTest(ApiTester $I): void
    {
        $newDir = uniqid("filemanagerapicest-test-folder-persisted-");
        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $newDir
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->sendGET('/filemanager/api/list', ["path" => "/" . $newDir]);

        // Comment this part below to keep test folders
        $I->sendDELETE('/filemanager/api/delete-directory?path=/'.$newDir);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testFilemanagerlist(ApiTester $I): void
    {
        $I->sendGET('/filemanager/api/list', ["path" => "/"]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }
}
