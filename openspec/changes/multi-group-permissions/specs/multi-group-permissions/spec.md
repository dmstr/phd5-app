change spec: ## ADDED Requirements

### Requirement: Multiple group permissions per StorageItem
The system SHALL allow any number of RBAC role-based group permissions to be stored per `StorageItem`. Each entry consists of a `group_name` (RBAC role name) and a `grant_mask` bitmask. `grant_mask` MUST NOT be null; every stored row represents an explicit permission decision. The absence of any row for an item means the item has no explicit permissions and permission is inherited from ancestors.

The bitmask is designed to be extensible. Currently defined bits:

| Bit | Value | Constant | Meaning |
|-----|-------|----------|---------|
| 0   | 1     | READ     | Read / open |
| 1   | 2     | CREATE   | Create new files/folders |
| 2   | 4     | UPDATE   | Modify existing files/folders |
| 3   | 8     | DELETE   | Delete files/folders |

Future bits (e.g. bit 4 = AV scan, bit 5 = Forward) SHALL be addable without schema changes, as the column type is `BIGINT UNSIGNED`. The combination `READ|CREATE|UPDATE|DELETE` (value 15) is currently the maximum meaningful mask but MUST NOT be treated as an upper limit.

#### Scenario: Store multiple groups on one item
- **WHEN** `updatePermissionsFromJson()` is called with `group: [{name:"Preview",grant:1},{name:"Editor",grant:15}]`
- **THEN** two rows exist in `storage_item_permission` for that item, each with a non-null `grant_mask`

#### Scenario: Replace existing group permissions
- **WHEN** `updatePermissionsFromJson()` is called with a new group array on an item that already has group permissions
- **THEN** all previous `storage_item_permission` rows for that item are deleted and only the new rows exist

#### Scenario: Clear all group permissions triggers inheritance
- **WHEN** `updatePermissionsFromJson()` is called with `group: []`
- **THEN** no `storage_item_permission` rows exist for that item, and permission resolution falls back to ancestor traversal

#### Scenario: grant_mask=0 explicitly blocks a group without inheritance
- **WHEN** a row exists with `grant_mask=0` for a given group
- **THEN** the item is considered to have explicit permissions (no ancestor traversal), and that group is granted nothing

### Requirement: Permission check uses all group entries
`checkPermissions()` SHALL grant access when any of the item's `storage_item_permission` entries has the requested flag set AND the user holds the matching RBAC role.

#### Scenario: User with matching role and sufficient grant is allowed
- **WHEN** a user holds role "Editor" and the item has a `storage_item_permission` entry `{group_name:"Editor", grant_mask:15}`
- **THEN** `checkPermissions(READ, user)` returns `true`

#### Scenario: User without any matching role is denied
- **WHEN** a user holds no role listed in `storage_item_permission` and `permission_other_grant` does not cover the flag
- **THEN** `checkPermissions(READ, user)` returns `false`

### Requirement: readableBy query uses multi-group mode with recursive inheritance
`StorageItemQuery::readableBy()` SHALL use an `EXISTS` subquery against `storage_item_permission` to filter items readable by the given user based on their RBAC roles. This is the sole query strategy — no legacy single-column fallback.

The absence of any `storage_item_permission` rows for a file or directory means the permission is inherited from its nearest ancestor that has at least one explicit row. The system SHALL walk the full ancestor chain (parent → grandparent → … → root) and stop at the first ancestor with entries. There are no null-value sentinel rows; absence of rows is the sole signal for "inherit".

#### Scenario: Direct group permission grants read access
- **WHEN** a user holds role "Preview" AND the item has `{group_name:"Preview", grant_mask:1}`
- **THEN** `readableBy(user)` includes the item in results

#### Scenario: Permission inherited across multiple levels
- **WHEN** an item has no `storage_item_permission` entries AND its parent has no entries AND its grandparent has `{group_name:"Preview", grant_mask:1}` AND the user holds role "Preview"
- **THEN** `readableBy(user)` includes the item in results

#### Scenario: Nearest ancestor with permissions wins
- **WHEN** an item has no entries AND its parent has `{group_name:"Editor", grant_mask:15}` AND its grandparent has `{group_name:"Preview", grant_mask:1}`
- **THEN** only the parent's entries are used (grandparent is not evaluated)

#### Scenario: Own permission overrides all ancestors
- **WHEN** an item has its own `storage_item_permission` entries
- **THEN** `readableBy(user)` does NOT fall back to any ancestor permissions for that item

#### Scenario: No ancestor has permissions — other grant applies
- **WHEN** an item and all its ancestors have no `storage_item_permission` entries
- **THEN** access is determined solely by `permission_other_grant` and `permission_owner_grant`

### Requirement: Legacy group columns are removed from storage_item after migration
After migrating group permission data from `storage_item` into `storage_item_permission`, the columns `permission_group_name` and `permission_group_grant` SHALL be dropped from the `storage_item` table via a dedicated migration. No code SHALL reference these columns after migration.

#### Scenario: Columns no longer exist after migration 3
- **WHEN** migration 3 runs
- **THEN** `storage_item` no longer has `permission_group_name` or `permission_group_grant` columns

#### Scenario: No fallback to dropped columns in checkPermissions
- **WHEN** an item has no `storage_item_permission` rows
- **THEN** `checkPermissions()` proceeds to ancestor traversal without consulting any legacy column

### Requirement: Migration from filefly_hashmap to storage_item and storage_item_permission
The system SHALL provide a console migration command that reads `filefly_hashmap` rows and performs two tasks for each row. If the `filefly_hashmap` table does not exist in the database, the command SHALL exit cleanly with an informational message and a zero exit code — no error or exception.

**Task A — Ensure a `storage_item` row exists:**
- The `filefly_hashmap.path` column holds the full path (e.g. `/folder/file.txt`). Split it into `name` (basename) and `path` (dirname).
- Match against `storage_item` using `storage_id = component` AND `path = dirname` AND `name = basename`.
- If a matching `storage_item` already exists, use it (no duplicate insert).
- If no match exists, create a new `storage_item` row with a generated UUID, using `component` → `storage_id`, `type`, derived `path`/`name`, `filefly_hashmap.created_at` / `updated_at`, and `access_owner` → `permission_owner`. The legacy group columns (`permission_group_name`, `permission_group_grant`) SHALL be left NULL.

**Task B — Migrate permissions into `storage_item_permission`:**
- `access_owner` → `storage_item.permission_owner` (set on both new and existing items)
- `access_read`, `access_update`, `access_delete` → `storage_item_permission` rows via bitmask (READ=1, UPDATE=4, DELETE=8)
- If `*` appears anywhere in an access column value, skip the entire column (no rows for that bit)
- Roles appearing in multiple columns have their masks ORed together
- Use upsert (`ON DUPLICATE KEY UPDATE grant_mask = VALUES(grant_mask)`) to handle already-existing `storage_item_permission` rows

The legacy group columns (`permission_group_name`, `permission_group_grant`) in `storage_item` SHALL remain NULL for all migrated rows. Permissions go exclusively into `storage_item_permission`.

#### Scenario: filefly_hashmap table does not exist — command exits cleanly
- **WHEN** the `filefly_hashmap` table is not present in the database
- **THEN** the command logs an informational message, exits with code 0, and produces no error or exception

#### Scenario: filefly_hashmap row with no existing storage_item — new row created
- **WHEN** no `storage_item` matches `component` + derived `path`/`name`
- **THEN** a new `storage_item` is created with a UUID, `storage_id=component`, `type`, `path`, `name`, `permission_owner=access_owner`, and `permission_group_name=NULL`

#### Scenario: filefly_hashmap row with existing storage_item — no duplicate created
- **WHEN** a `storage_item` already exists for `storage_id=component`, `path=dirname`, `name=basename`
- **THEN** no new `storage_item` row is inserted; the existing row is used for permission migration

#### Scenario: Legacy group columns remain NULL after migration
- **WHEN** the migration runs for any `filefly_hashmap` row
- **THEN** `storage_item.permission_group_name` and `storage_item.permission_group_grant` are NULL for that item

#### Scenario: Column contains only asterisk — no permission rows created
- **WHEN** `filefly_hashmap` has `access_read="*"` and `access_update=""` and `access_delete=""`
- **THEN** no `storage_item_permission` rows are created for that item's read bit (inheritance applies)

#### Scenario: Asterisk mixed with role names — asterisk wins, roles discarded
- **WHEN** `filefly_hashmap` has `access_read="*,Editor,OtherGroup"`
- **THEN** no `storage_item_permission` rows are created for that item's read bit; `Editor` and `OtherGroup` are ignored

#### Scenario: Role in single access column gets correct bitmask
- **WHEN** `filefly_hashmap` has `access_read="Editor"` and `access_update=""` and `access_delete=""`
- **THEN** one `storage_item_permission` row is created with `group_name="Editor"` and `grant_mask=1`

#### Scenario: Role in multiple access columns gets combined bitmask
- **WHEN** `filefly_hashmap` has `access_read="Editor"` and `access_update="Editor"` and `access_delete="Editor"`
- **THEN** one `storage_item_permission` row is created with `group_name="Editor"` and `grant_mask=13` (READ+UPDATE+DELETE)

#### Scenario: Multiple roles in one column produce separate rows
- **WHEN** `filefly_hashmap` has `access_read="Preview,Editor"`
- **THEN** two `storage_item_permission` rows are created: `{group_name:"Preview", grant_mask:1}` and `{group_name:"Editor", grant_mask:1}`

#### Scenario: Existing storage_item_permission row is updated, not duplicated
- **WHEN** a `storage_item_permission` row already exists for that `(storage_item_id, group_name)`
- **THEN** the row's `grant_mask` is updated via upsert; no duplicate row is inserted

#### Scenario: access_owner is migrated to storage_item.permission_owner
- **WHEN** `filefly_hashmap` has `access_owner="42"`
- **THEN** the `storage_item.permission_owner` is set to `"42"` (on the new or existing row)

### Requirement: Permissions API returns and accepts multi-group JSON format
The `PermissionsController` SHALL accept and return a structured JSON object with `owner`, `group` (array), and `other` keys matching the canonical schema at `src/schemas/permissions.json`.

#### Scenario: GET permissions/view returns current permissions
- **WHEN** `GET /permissions/view?id={id}` is called by a user with read access
- **THEN** the response contains `{id, path, name, permissions: {owner, group[], other}}`

#### Scenario: PUT permissions/update persists all groups
- **WHEN** `PUT /permissions/update` is called with `{id, permissions:{owner,group:[...],other}}`
- **THEN** all group entries are persisted and the response echoes back the full permissions object

#### Scenario: GET permissions/schema returns the JSON-Schema document
- **WHEN** `GET /permissions/schema` is called
- **THEN** the response is a valid JSON-Schema object describing the permissions format

### Requirement: actionUpdate validates the permissions payload against permissions.json
`actionUpdate()` SHALL validate the incoming `permissions` object against `src/schemas/permissions.json` using `justinrainbow/json-schema` before passing it to `updatePermissionsFromJson()`. Invalid payloads MUST be rejected with HTTP 422 and a structured error response listing the validation failures.

#### Scenario: Valid payload passes validation and is persisted
- **WHEN** `PUT /permissions/update` receives `{id, permissions:{owner:1,group:[{name:"Editor",grant:15}],other:0}}`
- **THEN** the payload passes schema validation and all group entries are persisted

#### Scenario: Invalid payload is rejected with 422
- **WHEN** `PUT /permissions/update` receives a payload where `permissions.group` contains an entry without a `name` key
- **THEN** the response is HTTP 422 with a body describing the schema violation; no data is written

#### Scenario: Payload with unknown top-level property is rejected
- **WHEN** `PUT /permissions/update` receives `{id, permissions:{owner:1,group:[],other:0,extra:"x"}}`
- **THEN** the response is HTTP 422 (`additionalProperties` violation); no data is written

### Requirement: Filemanager widget derives grant options from permissions.json schema
`prompt-input.js` SHALL NOT hardcode grant option values. When a `json-editor` input is initialised, the Vue component SHALL fetch `property.schemaUrl` (i.e. `GET /permissions/schema`) and derive the `GRANT_OPTIONS` list from `schema.properties.owner.enumSource[0].source`, mapping `{value, title}` → `{value, label}`. This ensures the UI automatically reflects any changes to the allowed grant values in `permissions.json` without a frontend rebuild.

#### Scenario: Grant options are loaded from schema on dialog open
- **WHEN** the permissions dialog is opened
- **THEN** `prompt-input.js` fetches `schemaUrl` and populates the owner/group/other `<select>` options from `enumSource[0].source`

#### Scenario: New grant value added to permissions.json is visible in UI without code change
- **WHEN** a new entry is added to `permissions.json`'s `enumSource[0].source` (e.g. `{value:16, title:"16 — Forward"}`)
- **THEN** the new option appears in the grant `<select>` dropdowns on next dialog open without any change to `prompt-input.js`

### Requirement: Filemanager widget renders structured permissions form for multi-group editing
The `Filemanager` widget in `yii2-flysystem-widgets` SHALL render the permission dialog using the Vue `json-editor` input type (handled in `prompt-input.js`). `Filemanager.php` configures the `permissions` action with `type: 'json-editor'`, `viewUrl`, and `schemaUrl`. The Vue component renders a structured inline form with owner/other bitmask selects and a dynamic group list (name + grant select + remove button). The legacy flat input fields are removed.

#### Scenario: Permission dialog loads current permissions
- **WHEN** a user opens the permission dialog for a file/folder
- **THEN** the Vue component fetches `GET /permissions/view?id={uuid}` and pre-populates the owner, group[], and other fields

#### Scenario: Saving permissions submits new JSON format
- **WHEN** a user clicks save in the permission dialog
- **THEN** the widget submits a `PUT /permissions/update` request with `{id, permissions: {owner, group[], other}}`; groups with `grant <= 0` are omitted from the payload

#### Scenario: User can add and remove group entries
- **WHEN** a user clicks the add-group button and enters a group name + selects a grant value
- **THEN** a new group entry is appended to the group list and included in the next save

#### Scenario: User can remove an existing group entry
- **WHEN** a user clicks the remove button for a group row
- **THEN** that group is removed from the list and will not be present in the saved permissions
