## ADDED Requirements

### Requirement: Effective permission hashmap table per directory and group
The system SHALL maintain a table `storage_item_effective_permission` with columns `storage_item_id`, `group_name`, and `effective_grant_mask` (BIGINT UNSIGNED). Only directory-type `StorageItem` records SHALL have entries in this table. The composite primary key is `(storage_item_id, group_name)`.

#### Scenario: Hashmap entry exists for each group in ancestor chain
- **WHEN** a directory has ancestors whose `storage_item_permission` entries collectively cover groups A, B, and C
- **THEN** `storage_item_effective_permission` contains exactly three entries for that directory (one per group A, B, C)

#### Scenario: Groups not present anywhere in ancestor chain are absent
- **WHEN** a group has no `storage_item_permission` entry anywhere in the ancestor chain of a directory
- **THEN** no `storage_item_effective_permission` entry exists for that group and directory

### Requirement: default_grant field on root StorageItem
Root `StorageItem` records (items with no parent) SHALL have a `default_grant` field (BIGINT UNSIGNED NOT NULL DEFAULT 0). This value is used as the fallback effective mask for any group that has no entry in `storage_item_effective_permission` for the accessed item or its parent directory.

#### Scenario: default_grant is returned when no hashmap entry exists for a group
- **WHEN** a user belonging to GruppeX accesses a file whose parent directory has no `storage_item_effective_permission` entry for GruppeX
- **THEN** the effective grant for GruppeX is the `default_grant` of the root item

#### Scenario: default_grant of 0 denies access
- **WHEN** `default_grant = 0` on the root and no hashmap entry exists for a group
- **THEN** `checkPermissions()` returns false for that group

### Requirement: Per-group independent traversal during recompute
`recomputeEffectivePermissions()` SHALL resolve each group's effective mask independently. For a given directory and group, it SHALL walk the ancestor chain (self → parent → grandparent → … → root) and use the `grant_mask` from the first `storage_item_permission` entry found for exactly that group. It SHALL NOT stop traversal for one group because another group was found at a higher level.

#### Scenario: Two groups resolved independently from different ancestor levels
- **WHEN** a directory foo3 has no explicit permissions; foo2 (parent) has GruppeA; foo1 (grandparent) has GruppeB; recompute runs for foo3
- **THEN** foo3's hashmap entry for GruppeA uses foo2's mask AND foo3's hashmap entry for GruppeB uses foo1's mask

#### Scenario: Group found at self-level stops traversal for that group
- **WHEN** foo3 has an explicit `storage_item_permission` entry for GruppeA AND foo2 also has an entry for GruppeA
- **THEN** foo3's hashmap entry for GruppeA uses foo3's own mask (foo2 is not consulted for GruppeA)

#### Scenario: User with multiple groups gets OR-combined effective mask
- **WHEN** user U2 belongs to GruppeA (effective mask 1) and GruppeC (effective mask 4) for directory foo3
- **THEN** `checkPermissions(READ|UPDATE, U2)` evaluates against mask `1 | 4 = 5` and returns true

### Requirement: Configurable synchronous or queued hashmap recompute on permission change
When `storage_item_permission` entries for a directory are updated (via `updatePermissionsFromJson()`), the system SHALL trigger a recompute for that directory and all its descendants. The recompute strategy is determined by `Module::$recomputeQueueThreshold`:

- If the number of descendants is **at or below** the threshold (or threshold is `-1`): recompute synchronously within the same operation
- If the number of descendants **exceeds** the threshold (or threshold is `0`): dispatch a queue job via `hrzg/yii2-resque`; log a warning that the hashmap is temporarily stale

#### Scenario: Small tree recomputed synchronously
- **WHEN** `updatePermissionsFromJson()` is called on a directory with fewer descendants than `recomputeQueueThreshold`
- **THEN** `storage_item_effective_permission` entries for the directory and all descendants are updated before the response returns

#### Scenario: Large tree recompute dispatched to queue
- **WHEN** `updatePermissionsFromJson()` is called on a directory whose descendant count exceeds `recomputeQueueThreshold`
- **THEN** a queue job is dispatched to recompute the subtree; a warning is logged that the hashmap may be stale until the job completes

#### Scenario: threshold -1 forces synchronous recompute regardless of tree size
- **WHEN** `Module::$recomputeQueueThreshold = -1`
- **THEN** recompute is always synchronous, regardless of descendant count

#### Scenario: threshold 0 forces queue recompute regardless of tree size
- **WHEN** `Module::$recomputeQueueThreshold = 0`
- **THEN** recompute is always dispatched to queue, regardless of descendant count

#### Scenario: Hashmap updated when directory is created
- **WHEN** a new directory is inserted into `storage_item`
- **THEN** `recomputeEffectivePermissions()` is called (synchronously, as new directories have no descendants), producing hashmap entries for all groups found in its ancestor chain

### Requirement: Hashmap recompute console command with dry-run support
The system SHALL provide a console command `yii storage/recompute-effective-permissions` that rebuilds all `storage_item_effective_permission` entries from scratch. The command SHALL accept a `--dry-run` flag that computes and prints what would be written without modifying the database. The command SHALL print a summary of directories processed and entries written (or would-be-written in dry-run mode).

#### Scenario: Full recompute produces correct entries
- **WHEN** `yii storage/recompute-effective-permissions` is run after truncating `storage_item_effective_permission`
- **THEN** all entries are rebuilt correctly and match what incremental recompute would produce

#### Scenario: Command is idempotent
- **WHEN** `yii storage/recompute-effective-permissions` is run twice in a row without any permission changes
- **THEN** the resulting `storage_item_effective_permission` table is identical after both runs

#### Scenario: Dry-run produces no DB writes
- **WHEN** `yii storage/recompute-effective-permissions --dry-run` is run
- **THEN** no rows are inserted, updated, or deleted in `storage_item_effective_permission`; the command prints what would have been written

#### Scenario: Dry-run output matches actual recompute
- **WHEN** `--dry-run` is run on a clean database and then `recompute-effective-permissions` (without flag) is run
- **THEN** the entries written match exactly what dry-run reported
