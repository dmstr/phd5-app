<?php

declare(strict_types=1);

use Codeception\Util\HttpCode;

/**
 * @group wip
 */
final class FilemanagerApiDeleteDirectoryCest {

    public function _before(ApiTester $I): void
    {
        $I->authenticate('admin', 'admin1');
    }



    public function testCreateThenDeleteDirInDir(ApiTester $I)
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

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDirName . '/' . $childDirName);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);

        $I->sendGET('/filemanager/api/list', ['path' => '/' . $parentDirName]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContainsJson(['name' => $childDirName]);
    }
    public function testCreateThenDeleteFirstDirInDir(ApiTester $I)
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

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDirName);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'Directory is not empty and can not be deleted']);

        $I->sendGET('/filemanager/api/list', ['path' => '/']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $parentDirName]);
    }
    public function testDeleteDotDirInDir(ApiTester $I)
    {
        $parentDirName = uniqid("filemanagerapicest-test-folder-parent-");

        $I->sendPOST('/filemanager/api/create-directory', [
            'path' => '/',
            'name' => $parentDirName
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true, 'message' => 'created']);

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDirName . '/.');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();

        $I->sendDELETE('/filemanager/api/delete-directory?path=/' . $parentDirName . '/..');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();

        $I->sendGET('/filemanager/api/list', ['path' => '/']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['name' => $parentDirName]);
    }
}