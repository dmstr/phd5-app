<?php

declare(strict_types=1);

use Codeception\Util\HttpCode;

/**
 * @group wip
 */
final class FilemanagerApiCreateDirectoryCest {

    public function _before(ApiTester $I): void
    {
        $I->authenticate('admin', 'admin1');
    }


    public function testCreateDirectory(ApiTester $I)
    {
        $dirName = uniqid("filemanagerapicest-test-folder-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);
    }

    public function testCreateDirInDir(ApiTester $I)
    {
        $parentDirName = uniqid("filemanagerapicest-test-folder-parent-");
        $childDirName = uniqid("filemanagerapicest-test-folder-child-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/' . $parentDirName,
            'name' => $childDirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDirName]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $childDirName]);
    }


    public function testCreateDirectoryWithSpecialCharacters(ApiTester $I)
    {
        $specialDirs = [
            uniqid("filemanagerapicest-test-folder-parent-test-with-dash-"),
            //uniqid("filemanagerapicest-test-folder-parent-test_with_underscore-"),
            //uniqid("filemanagerapicest-test-folder-parent-test with space-"),
            //uniqid("filemanagerapicest-test-folder-parent-test.with.dots-"),
        ];

        foreach ($specialDirs as $dirName) {
            $I->sendPOST('/filemanager/api/create-directory', [
                'path' => '/',
                'name' => $dirName
            ]);
            $I->seeResponseCodeIs(HttpCode::CREATED);
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
        $longDirName = uniqid("filemanagerapicest-test-folder-") . str_repeat('verylongdirectoryname', 9);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $longDirName
        ]);

        $I->seeResponseIsJson();
    }

    public function testCreateDuplicateDirectory(ApiTester $I) //TODO Is 400 right here?
    {
        $dirName = uniqid("filemanagerapicest-test-folder-duplicate-test-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $dirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
        $I->seeResponseIsJson();
        //$I->seeResponseContainsJson(['success' => false]);
    }
}
