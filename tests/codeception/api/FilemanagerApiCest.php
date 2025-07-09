<?php

declare(strict_types=1);

use Codeception\Util\Debug;
use Codeception\Util\HttpCode;
use Faker\Factory;

/**
 * @group wip
*/
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

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/" . $dirName]);
        $I->seeResponseContainsJson(["message" => ""]);

        $I->amGoingTo('get a directory called ' . $dirName);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["name" => $dirName]);
        $I->seeResponseContainsJson(["fullPath" => "/" . $dirName]);

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

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/" . $dirName]);

        $I->amGoingTo('create a directory called ' . $dirName . "-2 inside the directory called " . $dirName);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $dirName,
            'name' => $dirName . "-2"
        ]);

        $I->seeResponseContainsJson(["success" => true]);
        $I->seeResponseContainsJson(["path" => "/" . $dirName . "/" . $dirName . "-2"]);;

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
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->sendGET('/filemanager/api/list', ["path" => "/" . $newDir]);

        // Comment this part below to keep test folders
//        $I->sendDELETE('/filemanager/api/delete-directory?path=/'.$newDir);
//        $I->seeResponseIsJson();
//        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testFilemanagerlist(ApiTester $I): void
    {
        $I->sendGET('/filemanager/api/list', ["path" => "/"]);

        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }


    public function testCreateDirectory(ApiTester $I)
    {
        $faker = Factory::create();
        $name = basename($faker->filePath());

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $name
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);
    }

    public function testCreateDirInDir(ApiTester $I)
    {
        $faker = Factory::create();
        $parentDir = 'parent-' . uniqid();
        $childDir = 'child-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDir,
            'name' => $childDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDir]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $childDir]);
    }
    public function testCreateThenDeleteDirInDir(ApiTester $I)
    {
        $parentDir = 'parent-' . uniqid();
        $childDir = 'child-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDir,
            'name' => $childDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDir]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $childDir]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDir . '/' . $childDir);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDir]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContainsJson(['name' => $childDir]);
    }
    public function testCreateThenDeleteFirstDirInDir(ApiTester $I)
    {
        $parentDir = 'parent-' . uniqid();
        $childDir = 'child-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDir,
            'name' => $childDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDir]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $childDir]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDir);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'Directory is not empty and can not be deleted']);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $parentDir]);
    }
    public function testDeleteDotDirInDir(ApiTester $I)
    {
        $parentDir = 'parent-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDir . '/.');
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDir . '/..');
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $I->sendGET('/filemanager/api/list', ['path' => '/']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $parentDir]);
    }

    public function testCreateDirectoryWithSpecialCharacters(ApiTester $I)
    {
        $specialDirs = [
            'test-with-dash-' . uniqid(),
            'test_with_underscore_' . uniqid(),
            'test with space ' . uniqid(),
            'test.with.dots.' . uniqid()
        ];

        foreach ($specialDirs as $dirName) {
            $I->sendPOST('/filemanager/api/create-directory', [
                'path' => '/',
                'name' => $dirName
            ]);
            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseIsJson();
            $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

            $I->sendGET('/filemanager/api/list', ['path' => '/']);
            $I->seeResponseCodeIs(HttpCode::OK);
            $I->seeResponseIsJson();
            $I->seeResponseContainsJson(['name' => $dirName]);
        }
    }

    public function testCreateDirectoryWithLongName(ApiTester $I)
    {
        $longDirName = str_repeat('verylongdirectoryname', 10) . uniqid();
        
        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $longDirName
        ]);
        
        $I->seeResponseIsJson();
    }

    public function testCreateDuplicateDirectory(ApiTester $I)
    {
        $dirName = 'duplicate-test-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::INTERNAL_SERVER_ERROR);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => false]);
    }

    public function testCreateDirectoryWithInvalidPath(ApiTester $I)
    {
        $dirName = 'invalid-path-test-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/nonexistent/path',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => false]);
    }

    public function testListDirectoryContents(ApiTester $I)
    {
        $parentDir = 'list-test-parent-' . uniqid();
        $childDir1 = 'child1-' . uniqid();
        $childDir2 = 'child2-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDir,
            'name' => $childDir1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDir,
            'name' => $childDir2
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDir]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $childDir1]);
        $I->seeResponseContainsJson(['name' => $childDir2]);
    }

    public function testDeepNestedDirectoryOperations(ApiTester $I)
    {
        $level1 = 'level1-' . uniqid();
        $level2 = 'level2-' . uniqid();
        $level3 = 'level3-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $level1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $level1,
            'name' => $level2
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $level1 . '/' . $level2,
            'name' => $level3
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $level1 . '/' . $level2]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $level3]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $level1 . '/' . $level2 . '/' . $level3);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $level1 . '/' . $level2]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContainsJson(['name' => $level3]);
    }

    public function testDirectoryPermissions(ApiTester $I)
    {
        $testDir = 'permissions-test-' . uniqid();

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $testDir
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $testDir]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['guiPermissions' => ['read' => true]]);
        $I->seeResponseContainsJson(['guiPermissions' => ['write' => true]]);
        $I->seeResponseContainsJson(['guiPermissions' => ['delete' => true]]);
        $I->seeResponseContainsJson(['guiPermissions' => ['canChangePermissions' => true]]);
    }

}
