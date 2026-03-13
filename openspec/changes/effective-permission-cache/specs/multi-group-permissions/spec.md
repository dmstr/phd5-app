## MODIFIED Requirements

### Requirement: Permission check uses hashmap lookup instead of runtime traversal
`checkPermissions()` SHALL resolve permissions via `storage_item_effective_permission` instead of runtime ancestor traversal. For a **directory**: look up `(storage_item_id, group_name)` in `storage_item_effective_permission` for each of the user's groups; OR the resulting masks; check the requested flag. For a **file**: if the file has its own `storage_item_permission` rows, use those (existing behaviour); if it has none, use the `storage_item_effective_permission` entries of its parent directory. If no hashmap entry exists for a group, fall back to `default_grant` of the root item.

#### Scenario: User with matching role is allowed via hashmap
- **WHEN** a user holds role "Editor" and the directory has a `storage_item_effective_permission` entry `{group_name:"Editor", effective_grant_mask:15}`
- **THEN** `checkPermissions(READ, user)` returns `true`

#### Scenario: User without any matching hashmap entry is denied
- **WHEN** a user holds no role that appears in `storage_item_effective_permission` for the directory and `default_grant = 0`
- **THEN** `checkPermissions(READ, user)` returns `false`

#### Scenario: File without explicit permissions uses parent directory hashmap
- **WHEN** a file has no `storage_item_permission` rows AND its parent directory has `{group_name:"Preview", effective_grant_mask:1}`
- **THEN** `checkPermissions(READ, user_in_Preview)` on the file returns `true`

#### Scenario: File with explicit permissions ignores parent hashmap
- **WHEN** a file has its own `storage_item_permission` rows
- **THEN** `checkPermissions()` uses only those rows; the parent directory's hashmap is NOT consulted

### Requirement: readableBy query uses hashmap join instead of EXISTS subquery
`StorageItemQuery::readableBy()` SHALL join against `storage_item_effective_permission` to filter readable directories, instead of using a recursive `EXISTS` subquery with ancestor traversal. For files, it SHALL join against the hashmap of the parent directory when the file has no own `storage_item_permission` rows.

#### Scenario: readableBy returns directory readable via hashmap
- **WHEN** a user holds role "Preview" AND the directory has `{group_name:"Preview", effective_grant_mask:1}`
- **THEN** `readableBy(user)` includes the directory in results

#### Scenario: readableBy excludes directory with no matching hashmap entry and default_grant 0
- **WHEN** a user holds only roles not present in `storage_item_effective_permission` for a directory AND `default_grant = 0`
- **THEN** `readableBy(user)` excludes the directory from results
