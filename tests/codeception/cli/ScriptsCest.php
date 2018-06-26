<?php


class ScriptsCest
{
    public function _before(CliTester $I)
    {
    }

    public function _after(CliTester $I)
    {
    }

    // tests
    public function uniqueNumber(CliTester $I)
    {
        $I->runShellCommand('/usr/local/bin/unique-number.sh 999');
        $I->canSeeShellOutputMatches('/[0-9]{1,3}/');
    }
}
