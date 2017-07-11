# Upgrading

### 5.1.0 to 5.2.0

- update `composer.json` settings

### 5.0.0 to 5.1.0

- local filesystem `fs` has been renamed to `fsLocal`
- added host-volume for `src/` in test stack 

### 5.0.0-beta to 5.0.0

- add `"wikimedia/composer-merge-plugin": "~1.3.1"`; must be a local package (not global)
- remove `"romka-chev/yii2-swiper": "^2.0"`, due to composer conflicts with asset-plugin
- `MYSQL_ROOT_PASSWORD` has been deprecated, use `DB_ENV_MYSQL_ROOT_PASSWORD`
- add `APP_AUDIT_DISABLE_ALL_ACTIONS=1`

### 4.1.0 to 5.0.0-beta

TBD