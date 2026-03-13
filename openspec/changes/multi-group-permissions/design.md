## Context

`yii2-flysystem-rest-api` stores file/folder metadata in `storage_item`. Each item has three permission columns: `permission_owner` / `permission_owner_grant`, `permission_group_name` / `permission_group_grant`, and `permission_other_grant`. The single-group limitation blocks multi-role access scenarios. `yii2-flysystem-widgets` contains the Filemanager widget which currently renders the permission dialog using the old flat format.

## Goals / Non-Goals

**Goals:**
- Store N group permissions per StorageItem in a normalized relation table
- Migrate existing single-group data from `storage_item` columns to `storage_item_permission`, then drop the legacy columns
- `readableBy()` always uses multi-group EXISTS subquery with recursive ancestor traversal
- Expose new `GET /permissions/view`, `GET /permissions/schema`, and updated `PUT /permissions/update` endpoints
- Replace the filemanager permission form with a `dmstr/yii2-json-editor` driven JSON editor

**Non-Goals:**
- Automatic detection of filefly_hashmap data; migration is a manually triggered console command

## Decisions

### 1. Separate table over JSON column
A dedicated `storage_item_permission` table (`storage_item_id`, `group_name`, `grant_mask`) is used instead of a JSON column on `storage_item`.

*Rationale:* SQL `EXISTS` subqueries can filter directly without `JSON_EXTRACT`/`JSON_TABLE`; columns are indexable and can carry FK + UNIQUE constraints. Consistent with the existing relational model.

*Alternative:* JSON column — rejected because MySQL JSON functions are less portable, harder to index, and not supported in MariaDB older versions.

### 2. grant_mask is BIGINT UNSIGNED, no upper bound
`grant_mask` uses `BIGINT UNSIGNED NOT NULL DEFAULT 0`. It MUST NOT be null. The currently defined bits occupy positions 0–3 (values 1–8). Future permissions (e.g. AV scan, Forward) SHALL occupy higher bits without requiring a schema change. Value 15 (`READ|CREATE|UPDATE|DELETE`) is the current maximum meaningful combination but MUST NOT be enforced as a column constraint.

*Rationale:* Using `BIGINT UNSIGNED` (64 bits) leaves 60 bits for future extension. Any tighter constraint (e.g. `TINYINT` or `CHECK (grant_mask <= 15)`) would require a migration for each new permission type.

### 3. Absence of rows = inherit; no null-sentinel rows
The `storage_item_permission` table contains only explicit permission decisions. If a `StorageItem` has zero rows, permission resolution walks the ancestor chain. There are no "null" or "placeholder" rows to signal inheritance — the absence of rows is the signal.

`grant_mask=0` is a valid explicit value meaning "this group has no permissions on this item" and blocks ancestor traversal for that item (the item is considered to have explicit permissions).

*Rationale:* Null-sentinel rows complicate queries and CREATE/DELETE logic. Empty-means-inherit is unambiguous and consistent with how filesystem ACL inheritance works.

### 4. Legacy group columns are dropped after migration
After copying all group permission data from `storage_item` (`permission_group_name`, `permission_group_grant`) into `storage_item_permission`, a third migration drops those two columns. No application code retains a fallback to the dropped columns.

*Rationale:* Keeping legacy columns after migration would require dual-write maintenance and creates ambiguity about which source is authoritative. A clean drop enforces a single source of truth.

### 5. Replace-strategy for group updates
`updatePermissionsFromJson()` deletes all existing `storage_item_permission` rows for the item before inserting the new set, all within a transaction.

*Rationale:* Simpler logic than upsert/diff; atomically correct; group lists are small.

*Alternative:* Upsert + delete orphans — rejected as more complex with no benefit for typical group counts (<10).

### 6. `readableBy()` always uses multi-group EXISTS with recursive inheritance
`readableBy()` uses `EXISTS` subquery on `storage_item_permission` unconditionally. No feature flag; no legacy column path. When an item has no rows, the query walks the full ancestor chain (parent → grandparent → … → root) and uses the entries of the first ancestor that has any rows.

*Rationale:* Eliminating the code path for the old single-column logic reduces complexity and removes the risk of divergent behaviour between modes.

### 7. filefly_hashmap migration strategy
A console command `yii storage/migrate-from-filefly` performs two tasks per `filefly_hashmap` row.

**Task A — Ensure a `storage_item` row exists:**
`filefly_hashmap.path` is the full path (e.g. `/folder/file.txt`). Split into `name` (basename) and `path` (dirname). Look up `storage_item` by `storage_id=component` + `path=dirname` + `name=basename`. If found, reuse it. If not, INSERT a new row (generate a UUID, map `component`→`storage_id`, `type`, derived `path`/`name`, timestamps, `access_owner`→`permission_owner`). The legacy group columns (`permission_group_name`, `permission_group_grant`) are never written by this command and remain NULL.

**Task B — Migrate permissions into `storage_item_permission`:**

| filefly_hashmap column | Target |
|---|---|
| `access_owner` | `storage_item.permission_owner` (written for both new and existing rows) |
| `access_read` (CSV roles, no `*`) | `storage_item_permission` rows with `grant_mask |= 1` |
| `access_update` (CSV roles, no `*`) | `storage_item_permission` rows with `grant_mask |= 4` |
| `access_delete` (CSV roles, no `*`) | `storage_item_permission` rows with `grant_mask |= 8` |

**Asterisk semantics — `*` wins:** if `*` appears anywhere in an access column value (alone or mixed), the entire column is skipped; no `storage_item_permission` rows for that bit. Any role names alongside `*` are discarded.

Roles appearing in multiple columns have their masks ORed together. `storage_item_permission` inserts use `ON DUPLICATE KEY UPDATE grant_mask = VALUES(grant_mask)` for idempotency. The command can be run multiple times safely.

*Rationale:* Combining `storage_item` creation with permission migration in one command avoids a two-step manual process. Duplicate detection at both levels ensures idempotency. `*` wins because silently dropping explicit grants is safer than accidentally creating rows the old system intended to inherit.

### 8. `permissions.json` as single source of truth for grant values
`src/schemas/permissions.json` defines all valid grant values via `enumSource[0].source` (e.g. 0, 1, 2, 4, 8, 15). This file serves two purposes:

1. **Server-side validation** — `actionUpdate()` validates the incoming `permissions` payload against `permissions.json` using `justinrainbow/json-schema`. Invalid payloads return HTTP 422.
2. **Frontend options** — `prompt-input.js` fetches `schemaUrl` on dialog open and builds `GRANT_OPTIONS` from `schema.properties.owner.enumSource[0].source`. Adding a new grant value to the schema propagates to the UI without a frontend rebuild.

*Rationale:* `permissions.json` is already exposed via `GET /permissions/schema`. Using it as the authoritative source for both validation and UI options eliminates the risk of the hardcoded `GRANT_OPTIONS` array in `prompt-input.js` drifting from the server-enforced values.

*Alternative:* Keep `GRANT_OPTIONS` hardcoded in `prompt-input.js` — rejected because any new bitmask value requires a frontend change in addition to a schema change.

### 9. Custom Vue `json-editor` input type (not PHP `JsonEditorWidget`)
The permissions dialog uses a custom `json-editor` input type handled entirely in the Vue layer (`prompt-input.js`). `Filemanager.php` sets `'type' => 'json-editor'` in the action's `input` config along with `schemaUrl` and `viewUrl`. The Vue component renders a structured form with owner/other select dropdowns and a dynamic group list (each group has a `name` text input, a `grant` select from bitmask values, and a remove button). Groups with `grant <= 0` are omitted from the submitted payload. The legacy flat inputs are removed entirely.

*Rationale:* The existing `JsonEditorWidget` PHP-side render would require a full page embed of the JSON editor library; the custom Vue form provides a more tightly integrated UX with the existing dialog/action system, avoids an extra PHP render pass, and keeps the bitmask select UX explicit rather than JSON-schema-driven. No new frontend dependency beyond what was already bundled in `prompt-input.js`.

*Alternative:* `dmstr\jsoneditor\JsonEditorWidget` PHP-side — rejected during implementation in favour of a native Vue component for consistency with how all other dialog inputs work.

## Risks / Trade-offs

- **N+1 on `readableBy()`** → The `EXISTS` subquery executes per row; mitigated by index on `(storage_item_id, group_name)`.
- **Ancestor traversal depth** → Deep hierarchies generate large subqueries; mitigated by path-prefix indexing on `storage_item.path`.
- **Column drop is destructive** → Migration 3 cannot be rolled back without data loss if group data was written only to the new table; mitigated by running Migration 2 first and verifying data before running Migration 3.
- **Transaction in `updatePermissionsFromJson()`** → Nested transactions not supported in Yii2 by default → Mitigation: callers must not wrap this call in their own transaction, or use savepoints.
- **No server-side JSON-Schema validation** → Invalid payloads may reach the model → Mitigation: ActiveRecord validation rules on `StorageItemPermission`; future: add `justinrainbow/json-schema` validator.

## Migration Plan

1. Deploy Migration 1: create `storage_item_permission` table
2. Deploy Migration 2: copy existing single-group rows from `storage_item` into `storage_item_permission`
3. *(Optional)* Run `yii storage/migrate-from-filefly` to import `filefly_hashmap` data
4. Deploy Migration 3: drop `permission_group_name` and `permission_group_grant` columns from `storage_item`
5. Deploy model/query/controller code changes
6. Deploy widget update

**Rollback:** Migration 3 is destructive — restore from backup or re-add columns manually. Migrations 1 and 2 are reversible via `safeDown`. Revert code. `filefly_hashmap` is never modified.

## Open Questions

- ~~Should `readableBy()` keep the legacy-column fallback?~~ → **Resolved:** legacy columns are dropped; `readableBy()` uses multi-group EXISTS unconditionally.
- ~~Is one-level ancestor inheritance sufficient, or do we need full recursive traversal?~~ → **Resolved:** Full recursive traversal up to the root is required. The nearest ancestor with `storage_item_permission` entries wins.
- ~~How should `*,Editor,OtherGroup` be treated in filefly_hashmap migration?~~ → **Resolved:** `*` wins; all role names alongside `*` are discarded.
