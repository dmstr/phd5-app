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
        $I->seeShellOutputMatches('/[0-9]{1,3}/');
    }

    public function auditCleanupEmptyEnv(CliTester $I)
    {
        $I->runShellCommand('env - /usr/local/bin/php /app/yii audit/cleanup --interactive=0 --entry --age=0');
        $I->seeInShellOutput('Cleanup was successful.');
    }
}
