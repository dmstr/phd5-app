## 1. Database Migrations (yii2-flysystem-rest-api)

- [x] 1.1 Create migration `m260312_000001_create_storage_item_permission_table.php` — table `storage_item_permission` with columns `id`, `storage_item_id` (string 36 NOT NULL), `group_name` (string 255 NOT NULL), `grant_mask` (`BIGINT UNSIGNED NOT NULL DEFAULT 0`), `created_at`, `updated_at`; unique index `(storage_item_id, group_name)`; FK to `storage_item`
- [x] 1.2 Create migration `m260312_000002_migrate_group_permissions_to_table.php` — `INSERT INTO storage_item_permission SELECT id, permission_group_name, permission_group_grant FROM storage_item WHERE permission_group_name IS NOT NULL`
- [x] 1.3 Create migration `m260312_000003_drop_legacy_group_columns.php` — drop columns `permission_group_name` and `permission_group_grant` from `storage_item`; `safeDown` re-adds the columns (data is not restored — document in migration comment)

## 2. StorageItemPermission Model (yii2-flysystem-rest-api)

- [x] 2.1 Create `src/models/StorageItemPermission.php` with `tableName()`, validation rules (required, string lengths, `grant_mask` integer min:0 — no upper bound, composite unique), `TimestampBehavior`, and `getStorageItem()` relation

## 3. StorageItem Model Changes (yii2-flysystem-rest-api)

- [x] 3.1 Add `getGroupPermissions()` `hasMany` relation to `StorageItemPermission`
- [x] 3.2 Implement `getPermissionsAsJson(): array` — returns `{owner, group[], other}` from `storage_item_permission` (no legacy column fallback)
- [x] 3.3 Implement `updatePermissionsFromJson(array $data): bool` — transactional replace-strategy for group entries
- [x] 3.4 Update `checkPermissions(int $flag, User $user): bool` — iterate `getGroupPermissions()` entries; no legacy column fallback

## 4. StorageItemQuery Changes (yii2-flysystem-rest-api)

- [x] 4.1 Replace single-group condition in `readableBy()` with `EXISTS` subquery on `storage_item_permission` for direct permissions on the item
- [x] 4.2 Add recursive ancestor inheritance branch: when the item has no `storage_item_permission` entries, walk the ancestor chain (parent → grandparent → … → root) and use the nearest ancestor that has entries; stop at first match
- [x] 4.3 Remove old single-column (`permission_group_name` / `permission_group_grant`) logic from `readableBy()`

## 5. filefly_hashmap Migration Command (yii2-flysystem-rest-api)

- [x] 5.1 Create console command `StorageMigrateController` (or extend existing) with action `migrate-from-filefly`
- [x] 5.2 At startup: check whether the `filefly_hashmap` table exists; if not, print an informational message and return exit code 0 (no exception)
- [x] 5.3 For each `filefly_hashmap` row: split `path` into `name` (basename) and `path` (dirname); look up `storage_item` by `storage_id=component` + `path=dirname` + `name=basename`
- [x] 5.4 Split `path` into `name` (basename) and `path` (dirname); look up `storage_item` by `storage_id=component` + `path=dirname` + `name=basename`
- [x] 5.5 If no matching `storage_item` exists: INSERT a new row — generate UUID, map `component`→`storage_id`, `type`, derived `path`/`name`, `access_owner`→`permission_owner`, `created_at`/`updated_at` from hashmap; leave `permission_group_name` and `permission_group_grant` NULL
- [x] 5.6 If a matching `storage_item` already exists: update `permission_owner = access_owner` on that row (no duplicate insert)
- [x] 5.7 For each access column (`access_read`, `access_update`, `access_delete`): if the value contains `*` anywhere, skip the entire column; otherwise parse CSV role names
- [x] 5.8 Collect unique role names across non-skipped columns and OR-combine bitmasks (READ=1, UPDATE=4, DELETE=8) per role
- [x] 5.9 Insert combined rows into `storage_item_permission` using upsert (`ON DUPLICATE KEY UPDATE grant_mask = VALUES(grant_mask)`) to handle duplicates
- [x] 5.10 Print summary: hashmap rows processed, `storage_item` rows created, rows reused (already existed), permissions imported, columns skipped (`*`), warnings

## 6. JSON Schema (yii2-flysystem-rest-api)

- [x] 6.1 Create `src/schemas/permissions.json` with the canonical schema (`owner`, `group[]`, `other`); `grant` field: `integer`, `minimum: 0`, no `maximum`; include `enumSource` dropdown with currently known values (0, 1, 2, 4, 8, 15) but designed to be extensible

## 7. PermissionsController Changes (yii2-flysystem-rest-api)

- [x] 7.1 Update `actionUpdate()` — accept `{id, permissions:{owner,group:[...],other}}` and call `updatePermissionsFromJson()`; remove legacy flat-format path
- [x] 7.2 Add `actionView()` — `GET /permissions/view?id={id}`, returns `{id, path, name, permissions}` via `getPermissionsAsJson()`
- [x] 7.3 Add `actionSchema()` — `GET /permissions/schema`, reads and returns `src/schemas/permissions.json`
- [x] 7.4 Register new actions in `behaviors()` / `actions()` / route config as needed

## 8. Filemanager Widget Changes (yii2-flysystem-widgets)

- [x] 8.1 Add `dmstr/yii2-json-editor` as a dependency (require in `composer.json` if not already present via phd5 merge) — already present via `src/composer.phd5.json`
- [x] 8.2 Replace legacy flat permission inputs in the `permissions` action config with a `json-editor` input type — **actual implementation**: `Filemanager.php` sets `'type' => 'json-editor'` in action `input` config (not `JsonEditorWidget` PHP rendering); `prompt-input.js` Vue component handles the `json-editor` type with a custom inline form rendering owner/group[]/other with dropdowns and dynamic "add group" support
- [x] 8.3 On dialog open: fetch current permissions via `GET /permissions/view` and populate the editor — `viewUrl` and `schemaUrl` added to action config in `Filemanager.php`; Vue `prompt-input.js` fetches and pre-populates `jsonState` on open
- [x] 8.4 On save: submit editor value as `permissions` JSON body to `PUT /permissions/update` — Vue serializes the `jsonState[attribute]` value as the `permissions` field; groups with `grant <= 0` are skipped

## 9. Schema Validation in actionUpdate (yii2-flysystem-rest-api)

- [x] 9.1 Require `justinrainbow/json-schema` in `composer.json` (or verify it is already present as a transitive dependency)
- [x] 9.2 In `actionUpdate()`: load `src/schemas/permissions.json`, validate the incoming `permissions` value using `JsonSchema\Validator`, return HTTP 422 with structured error list on failure; proceed to `updatePermissionsFromJson()` only on success

## 10. Schema-driven GRANT_OPTIONS in prompt-input.js (yii2-flysystem-widgets)

- [x] 10.1 Remove the hardcoded `GRANT_OPTIONS` constant from `prompt-input.js`
- [x] 10.2 On `created()` (or when a `json-editor` property is found): fetch `property.schemaUrl` and extract grant options from `response.properties.owner.enumSource[0].source`, mapping `{value, title}` → `{value, label}`; store in component data as `grantOptions`
- [x] 10.3 Handle fetch errors gracefully (log warning, fall back to empty options or a minimal default set so the dialog does not break)

## 11. Verification

- [ ] 11.1 Run Migration 1 on a test DB and verify `storage_item_permission` table with correct constraints
- [ ] 11.2 Run Migration 2 and verify existing single-group rows are copied correctly
- [ ] 11.3 Run Migration 3 and verify `permission_group_name` / `permission_group_grant` columns are gone from `storage_item`
- [ ] 11.4 Run `migrate-from-filefly` against a test DB with `filefly_hashmap` data; verify `*`-wins behaviour, bitmask combination, and upsert idempotency
- [ ] 11.5 Test `checkPermissions()` with multiple groups — correct role grants access, unrelated role is denied, no legacy column fallback
- [ ] 11.6 Test `readableBy()` — direct permission, multi-level inherited permission, own-permission overrides ancestor
- [ ] 11.7 Test `PUT /permissions/update` with valid payload — all groups persisted, response echoes full permissions object
- [ ] 11.8 Test `PUT /permissions/update` with invalid payload — HTTP 422 returned, no data written
- [ ] 11.9 Test `GET /permissions/view` and `GET /permissions/schema` endpoints
- [ ] 11.10 Verify Filemanager widget fetches schema on dialog open, populates grant dropdowns from `enumSource`, loads current permissions, and saves correctly
