<?php

class VersionCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $rootPath = realpath(__DIR__.'/../../..');

        $I->wantTo('check application versioning');

        $I->amGoingTo('check files in root path: '. $rootPath);
        $I->dontSeeFileFound('./version', $rootPath);

        $I->amGoingTo('check files in root path: '. $rootPath.'/src');
        $I->seeFileFound('version', $rootPath.'/src');
        $I->openFile($rootPath.'/src/version');

        $I->dontSeeInThisFile('dev');
        $I->dontSeeInThisFile('dirty');
        $I->dontSeeInThisFile('\n');
    }
}
