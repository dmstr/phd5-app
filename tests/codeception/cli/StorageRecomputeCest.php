<?php

use eluhr\flysystemRestApi\models\StorageItem;
use eluhr\flysystemRestApi\models\StorageItemEffectivePermission;
use eluhr\flysystemRestApi\models\StorageItemPermission;

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

    public static function _seedStorageItem()
    {

        StorageItemPermission::deleteAll();
        StorageItem::deleteAll();
        StorageItemEffectivePermission::deleteAll();
        $now = new \DateTimeImmutable()->format('Y-m-d H:i:s');
        $seeds = [
            [
                'storage_id' => 'fsLocal',
                'type' => 'root',
                'path' => '/',
                'name' => '.',
                'last_synced_at' => $now,
                'permission_owner' => '1',
                'permission_owner_grant' => 15,
                'permission_other_grant' => 0
            ],
            [
                'storage_id' => 'fsLocal',
                'type' => 'dir',
                'path' => '/',
                'name' => 'foo1',
                'last_synced_at' => $now,
                'permission_owner' => '1',
                'permission_owner_grant' => 15,
                'permission_other_grant' => 0
            ],
            [
                'storage_id' => 'fsLocal',
                'type' => 'dir',
                'path' => '/foo1',
                'name' => 'foo2',
                'last_synced_at' => $now,
                'permission_owner' => '1',
                'permission_owner_grant' => 15,
                'permission_other_grant' => 0
            ],
            [
                'storage_id' => 'fsLocal',
                'type' => 'dir',
                'path' => '/foo1/foo2',
                'name' => 'foo3',
                'last_synced_at' => $now,
                'permission_owner' => '1',
                'permission_owner_grant' => 15,
                'permission_other_grant' => 0
            ],


        ];
        foreach ($seeds as $seed) {
            $storageItem = new StorageItem();
            $storageItem->setAttributes($seed);
            $storageItem->save();
        }

        // Tree:
        //   root  → GruppeA (mask=1), GruppeB (mask=3)
        //   foo1  → GruppeB (mask=5), GruppeC (mask=4)
        //   foo2  → GruppeA (mask=15), GruppeB (mask=7)
        //   foo3  → (inherit)
        //
        $permissionSeeds = [
            ['name' => '.', 'group_name' => 'GruppeA', 'grant_mask' => 1],
            ['name' => '.', 'group_name' => 'GruppeB', 'grant_mask' => 3],
            ['name' => 'foo1', 'group_name' => 'GruppeB', 'grant_mask' => 5],
            ['name' => 'foo1', 'group_name' => 'GruppeC', 'grant_mask' => 4],
            ['name' => 'foo2', 'group_name' => 'GruppeA', 'grant_mask' => 15],
            ['name' => 'foo2', 'group_name' => 'GruppeB', 'grant_mask' => 7],
        ];
        foreach ($permissionSeeds as $seed) {
            $item = StorageItem::find()->where(['name' => $seed['name']])->one();
            $p = new StorageItemPermission();
            $p->setAttributes(['storage_item_id' => $item->id, 'group_name' => $seed['group_name'], 'grant_mask' => $seed['grant_mask']]);
            $p->save();
        }

        $root = StorageItem::find()->where(['name' => '.'])->one();
        $root->recomputeEffectivePermissions();
    }
}
