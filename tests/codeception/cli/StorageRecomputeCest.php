<?php

/**
 * Codeception CLI tests for `yii storage/recompute-effective-permissions`.
 *
 * Task 8.1: full recompute on seeded DB — entries correct, summary printed
 * Task 8.2: --dry-run — no rows written, output lists expected entries
 * Task 8.3: idempotency — run twice, table contents identical
 */
class StorageRecomputeCest
{
    public function _before(CliTester $I)
    {
        // TODO: seed storage_item and storage_item_permission with known test data
        // TODO: truncate storage_item_effective_permission before each test
    }

    public function _after(CliTester $I)
    {
        // TODO: clean up seeded test data
    }

    /**
     * Task 8.1 — full recompute produces correct entries and prints summary.
     */
    public function recomputeProducesCorrectEntriesAndPrintsSummary(CliTester $I)
    {
        // TODO: seed known tree (e.g. root + 2 dirs with GruppeA permissions)
        $I->runShellCommand('yii storage/recompute-effective-permissions');
        $I->seeInShellOutput('Done.');
        $I->seeInShellOutput('Directories processed');
        $I->seeInShellOutput('Written entries');
        // TODO: query DB and assert expected storage_item_effective_permission rows
    }

    /**
     * Task 8.2 — dry-run writes no rows but prints expected entries.
     */
    public function dryRunWritesNothingButPrintsExpectedEntries(CliTester $I)
    {
        // TODO: seed known tree
        $I->runShellCommand('yii storage/recompute-effective-permissions --dry-run');
        $I->seeInShellOutput('[dry-run]');
        $I->seeInShellOutput('Would write entries');
        // TODO: assert storage_item_effective_permission is still empty
    }

    /**
     * Task 8.3 — running the command twice yields identical table contents.
     */
    public function idempotentWhenRunTwice(CliTester $I)
    {
        // TODO: seed known tree
        $I->runShellCommand('yii storage/recompute-effective-permissions');
        // TODO: capture row count / hashes after first run

        $I->runShellCommand('yii storage/recompute-effective-permissions');
        // TODO: assert row count / hashes identical after second run
        $I->seeInShellOutput('Done.');
    }
}
