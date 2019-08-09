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

    public function simulateSchedulerEnv(CliTester $I)
    {
        $I->amGoingTo('prepare ENV variables export (usually done in startup command)');
        $I->runShellCommand('/usr/local/bin/export-env.sh');

        $I->wantTo('run a yii command with no ENV variables set');
        $I->runShellCommand('env -i sh /root/export-env && yii audit/cleanup --interactive=0 --entry --age=0');
        $I->seeInShellOutput('Cleanup was successful.');
    }
}
