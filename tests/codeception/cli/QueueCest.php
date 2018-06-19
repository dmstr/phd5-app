<?php

class QueueCest
{
    public function _before(CliTester $I)
    {
    }

    public function _after(CliTester $I)
    {
    }

    // tests
    public function runQueue(CliTester $I)
    {
        $I->runShellCommand('yii queue');
        $I->seeInShellOutput('Jobs');
    }
}
