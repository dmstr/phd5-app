# Upgrading

### 5.0.0 to 5.1.0

- added host-volume for `src/` in test stack
- added _setting_ `app.assets` > `settingsAssetList`
  - use `dmstr\modules\prototype\assets\DbAsset` for **LESS Themes**
- added application configuration parameter `backend.iframe.name` for **Backend** toolbar  
- local filesystem `fs` has been renamed to `fsLocal`
- removed default configuration for `guide` and `help` (update backend tests)

### 5.0.0-beta to 5.0.0

- add `"wikimedia/composer-merge-plugin": "~1.3.1"`; must be a local package (not global)
- remove `"romka-chev/yii2-swiper": "^2.0"`, due to composer conflicts with asset-plugin
- `MYSQL_ROOT_PASSWORD` has been deprecated, use `DB_ENV_MYSQL_ROOT_PASSWORD`
- add `APP_AUDIT_DISABLE_ALL_ACTIONS=1`

### 4.1.0 to 5.0.0-beta

TBD