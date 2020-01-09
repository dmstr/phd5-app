# Upgrading

### 5.3 to 5.4

- set `ENV COMPOSER=/app/composer.json` in project `Dockerfile`
- adjust merge path `"src/composer.phd5.json"` in project `composer.json`
- adjust config path `/app/config/` eg. in tests
- register empty `register_shutdown_function` for unit and functional tests, see also 
  - `tests/codeception/mock_register_shutdown_function.php`
  - `tests/codeception/functional/_bootstrap.php`
  - `tests/codeception/unit/_bootstrap.php`
- default value for `APP_ADMIN_EMAIL` removed, must be set in project

### 5.2 to 5.3

- upgrade `"wikimedia/composer-merge-plugin": "^1.4.1"` when using phd5-template
- update helper function `E2eTester::login` with updated CSS selectors

### 5.1 to 5.2

- Move *param* `yii.migrations` to `MigrateController` `migrationPath`

### 5.0 to 5.1

- added host-volume for `src/` in test stack
- added _setting_ `app.assets` > `settingsAssetList`
  - use `dmstr\modules\prototype\assets\DbAsset` for **LESS Themes**
  - see https://github.com/thomaspark/bootswatch/issues/573 in case of `variable @path is undefined`
- added application configuration parameter `backend.iframe.name` for **Backend** toolbar  
- local filesystem `fs` has been renamed to `fsLocal`
- removed default configuration for `guide` and `help` (update backend tests)
- remove `RUN cp src/app.env-dist src/app.env` in `Dockerfile` [phd5-template]
- remove manual setting of `PHP_USER_ID` (correct value is applied on the base-image according to the Docker image OS)
- use environment variables with prefix i.e. `DB_ENV_...`

### 5.0.0-beta to 5.0

- add `"wikimedia/composer-merge-plugin": "~1.3.1"`; must be a local package (not global)
- remove `"romka-chev/yii2-swiper": "^2.0"`, due to composer conflicts with asset-plugin
- `MYSQL_ROOT_PASSWORD` has been deprecated, use `DB_ENV_MYSQL_ROOT_PASSWORD`
- add `APP_AUDIT_DISABLE_ALL_ACTIONS=1`

### 4.1.0 to 5.0.0-beta

Not supported
