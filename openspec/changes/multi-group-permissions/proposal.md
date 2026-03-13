## Why

The current permission system in `yii2-flysystem-rest-api` only supports a single group per `StorageItem` (`permission_group_name` + `permission_group_grant`). This prevents real-world access scenarios where a folder needs to be readable by a "Preview" group but fully editable by an "Editor" group. The change is needed now as the filemanager UI (yii2-flysystem-widgets) is being extended and a proper multi-group API is required.

## What Changes

- New `storage_item_permission` table stores N group permissions per item (group_name + grant_mask bitmask)
- Migration transfers existing single-group data to the new table; legacy columns remain for backward compatibility
- `StorageItem` model gains a `groupPermissions` relation plus `getPermissionsAsJson()` / `updatePermissionsFromJson()` methods
- `checkPermissions()` iterates all group entries instead of checking a single column
- `readableBy()` query uses an `EXISTS` subquery against the new table with inheritance logic
- `PermissionsController` accepts the new JSON format (`owner` / `group[]` / `other`) on `actionUpdate` and gains two new endpoints: `actionView` (GET) and `actionSchema` (GET)
- Filemanager widget adds a custom Vue `json-editor` input type in `prompt-input.js` that renders owner/group[]/other with bitmask dropdowns and dynamic group management; `Filemanager.php` config sets `type: 'json-editor'` with `viewUrl`/`schemaUrl` — no PHP-side `JsonEditorWidget` render
- `src/schemas/permissions.json` is the single source of truth for valid grant values: `actionUpdate()` validates incoming payloads against it via `justinrainbow/json-schema` (HTTP 422 on failure); `prompt-input.js` fetches it via `schemaUrl` to populate the grant `<select>` options dynamically from `enumSource`

## Capabilities

### New Capabilities

- `multi-group-permissions`: Support for multiple RBAC-role-based group permissions per StorageItem, stored in a dedicated relation table with full inheritance support

### Modified Capabilities

- (none — no existing spec files to delta)

## Impact

- **yii2-flysystem-rest-api** (`vendor/eluhr/`): migrations (3 new), `StorageItem` model, `StorageItemPermission` model (new), `StorageItemQuery`, `PermissionsController` (new: `actionView`, `actionSchema`, updated `actionUpdate`), `StorageController` console command (`actionMigrateFromFilefly`), `src/schemas/permissions.json`
- **yii2-flysystem-widgets** (`vendor/eluhr/`): `Filemanager.php` action config, `prompt-input.js` Vue component (new `json-editor` input type)
- **Database**: new `storage_item_permission` table; `storage_item` `permission_group_name` + `permission_group_grant` columns dropped after migration
- **API consumers**: new JSON body format for `PUT /permissions/update`; two new endpoints `GET /permissions/view` and `GET /permissions/schema`
