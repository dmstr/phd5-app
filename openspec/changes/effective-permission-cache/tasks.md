## 1. Database Migration (yii2-flysystem-rest-api)

- [x] 1.1 Create migration `m260313_000001_create_storage_item_effective_permission_table.php` — table `storage_item_effective_permission` with columns `storage_item_id` (VARCHAR 36 NOT NULL), `group_name` (VARCHAR 255 NOT NULL), `effective_grant_mask` (BIGINT UNSIGNED NOT NULL DEFAULT 0); composite primary key `(storage_item_id, group_name)`; FK to `storage_item.id` ON DELETE CASCADE
- [x] 1.2 Create migration `m260313_000002_add_default_grant_to_storage_item.php` — add column `default_grant` (BIGINT UNSIGNED NOT NULL DEFAULT 0) to `storage_item`

## 2. StorageItemEffectivePermission Model (yii2-flysystem-rest-api)

- [x] 2.1 Create `src/models/StorageItemEffectivePermission.php` with `tableName()`, validation rules (`storage_item_id` required string 36, `group_name` required string 255, `effective_grant_mask` integer min:0), and `getStorageItem()` relation

## 3. recomputeEffectivePermissions() on StorageItem (yii2-flysystem-rest-api)

- [x] 3.1 Add `recomputeEffectivePermissions(): void` to `StorageItem` — collect all groups that appear in `storage_item_permission` anywhere in the ancestor chain (self → root); for each group walk the chain to find the nearest ancestor with an explicit entry for that group; delete all existing `storage_item_effective_permission` rows for this item; insert fresh rows
- [x] 3.2 After recomputing self, recurse to all direct children (query `storage_item` by parent path/id) and call `recomputeEffectivePermissions()` on each — depth-first, full subtree
- [x] 3.3 Add `Module::$recomputeQueueThreshold = 500` property; add `countDescendants(): int` helper on `StorageItem`
- [x] 3.4 In `updatePermissionsFromJson()`: after the transaction commits, count descendants; if count ≤ threshold (or threshold = -1) call `recomputeEffectivePermissions()` synchronously; if count > threshold (or threshold = 0) dispatch a `RecomputeEffectivePermissionsJob` via `yiisoft/yii2-queue` (`Yii::$app->{$module->queueComponent}->push(...)`) and log a warning
- [x] 3.5 Create `RecomputeEffectivePermissionsJob` (implements `yii\queue\JobInterface`) — receives `storage_item_id`, loads the item, calls `recomputeEffectivePermissions()`
- [x] 3.6 Call `recomputeEffectivePermissions()` synchronously in `afterSave` when a new directory-type `StorageItem` is inserted (new directories have no descendants, always below threshold)

## 4. checkPermissions() Update (yii2-flysystem-rest-api)

- [x] 4.1 For **directory** items: replace ancestor-traversal logic with a query on `storage_item_effective_permission WHERE storage_item_id = :id AND group_name IN (:userGroups)`; OR the returned `effective_grant_mask` values; check the requested flag; fall back to root `default_grant` if no rows returned
- [x] 4.2 For **file** items with no own `storage_item_permission` rows: query `storage_item_effective_permission` using the parent directory's `storage_item_id`; same OR + flag check + `default_grant` fallback
- [x] 4.3 For **file** items with own `storage_item_permission` rows: keep existing behaviour (no change)

## 5. readableBy() Update (yii2-flysystem-rest-api)

- [x] 5.1 For directories: replace `EXISTS` subquery with `JOIN storage_item_effective_permission ON storage_item_id = storage_item.id WHERE group_name IN (:userGroups) AND effective_grant_mask & :readFlag > 0`
- [x] 5.2 For files without own permission rows: join `storage_item_effective_permission` on the parent directory's id (use `storage_item.path` to derive parent id)
- [x] 5.3 Add `default_grant` fallback: include items where no hashmap entry exists for any of the user's groups but the root item's `default_grant` covers the READ flag

## 6. Console Command: recompute-effective-permissions (yii2-flysystem-rest-api)

- [x] 6.1 Add action `actionRecomputeEffectivePermissions(bool $dryRun = false)` to `StorageController` — when not dry-run: truncate `storage_item_effective_permission`, call `recomputeEffectivePermissions()` on every root directory (cascades to all descendants); when `--dry-run`: compute entries in memory without writing, collect would-be rows
- [x] 6.2 Print summary on completion: total directories processed, total hashmap entries written (or "would write" in dry-run mode); dry-run mode SHALL print each would-be entry (`storage_item_id`, `group_name`, `effective_grant_mask`)

## 7. Tests — yii2-flysystem-rest-api/tests/ (PHPUnit)

- [ ] 7.1 `EffectivePermissionRecomputeTest` — seed a 3-level tree (root→foo1→foo2→foo3) with permissions; call `recomputeEffectivePermissions()` on root; assert correct `storage_item_effective_permission` entries per group per directory
- [ ] 7.2 `EffectivePermissionRecomputeTest` — per-group independence: foo2 has GruppeA, foo1 has GruppeB; assert foo3 hashmap uses foo2's mask for GruppeA and foo1's mask for GruppeB
- [ ] 7.3 `CheckPermissionsTest` — directory: user in matching group is allowed; user in unmatched group with `default_grant=0` is denied
- [ ] 7.4 `CheckPermissionsTest` — file with no own permissions: uses parent directory hashmap entry
- [ ] 7.5 `CheckPermissionsTest` — file with own permissions: ignores parent hashmap
- [ ] 7.6 `CheckPermissionsTest` — user with multiple groups: masks are OR-combined
- [ ] 7.7 `ReadableByTest` — directory readable via hashmap; directory excluded with no match and `default_grant=0`
- [ ] 7.8 `RecomputeTriggerTest` — synchronous path: change permissions on small tree (below threshold), assert hashmap updated within same call
- [ ] 7.9 `RecomputeTriggerTest` — queue path: set `recomputeQueueThreshold=0`, change permissions, assert job dispatched and warning logged

## 8. Tests — tests/codeception/cli/ (Codeception, phd5-app)

- [ ] 8.1 `StorageRecomputeCest` — run `yii storage/recompute-effective-permissions` on seeded DB; assert hashmap entries correct and summary output printed
- [ ] 8.2 `StorageRecomputeCest` — run with `--dry-run`; assert no rows written, output lists expected entries
- [ ] 8.3 `StorageRecomputeCest` — run twice without changes; assert table contents identical (idempotency)
