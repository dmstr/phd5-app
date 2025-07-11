<?php

declare(strict_types=1);

use Codeception\Util\HttpCode;

/**
 * @group wip
 */
final class FilemanagerApiOperationsDirectoryCest {

    public function _before(ApiTester $I): void
    {
        $I->authenticate('admin', 'admin1');
    }


    public function testCreateDirectoryWithInvalidPath(ApiTester $I) //TODO Check response
    {
        $dirName = uniqid("filemanagerapicest-test-folder-invalid-path-test-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/nonexistent/path',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        //$I->seeResponseContainsJson(['success' => false]);
    }

    public function testListDirectoryContents(ApiTester $I)
    {
        $parentDirName = uniqid("filemanagerapicest-test-folder-list-test-parent-");
        $childDir1Name = uniqid("filemanagerapicest-test-folder-list-test-child1-");
        $childDir2Name = uniqid("filemanagerapicest-test-folder-list-test-child2-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDirName,
            'name' => $childDir1Name
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDirName,
            'name' => $childDir2Name
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDirName]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $childDir1Name]);
        $I->seeResponseContainsJson(['name' => $childDir2Name]);
    }

    public function testDeepNestedDirectoryOperations(ApiTester $I)
    {
        $dirNameLvl1 = uniqid("filemanagerapicest-test-folder-level1-");
        $dirNameLvl2 = uniqid("filemanagerapicest-test-folder-level2-");
        $dirNameLvl3 = uniqid("filemanagerapicest-test-folder-level3-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirNameLvl1
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $dirNameLvl1,
            'name' => $dirNameLvl2
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $dirNameLvl1 . '/' . $dirNameLvl2,
            'name' => $dirNameLvl3
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $dirNameLvl1 . '/' . $dirNameLvl2]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $dirNameLvl3]);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $dirNameLvl1 . '/' . $dirNameLvl2 . '/' . $dirNameLvl3);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $dirNameLvl1 . '/' . $dirNameLvl2]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContainsJson(['name' => $dirNameLvl3]);
    }

    public function testDirectoryPermissions(ApiTester $I) // TODO Check what is contained in Response
    {
        $dirName = uniqid("filemanagerapicest-test-folder-permissions-test-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $dirName]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        //$I->seeResponseContainsJson(['guiPermissions' => ['read' => true]]);
        //$I->seeResponseContainsJson(['guiPermissions' => ['write' => true]]);
        //$I->seeResponseContainsJson(['guiPermissions' => ['delete' => true]]);
        //$I->seeResponseContainsJson(['guiPermissions' => ['canChangePermissions' => true]]);
    }
}