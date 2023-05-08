# Configuration

## Environment variables

### `AMAZON_S3_BUCKET_NAME`
### `AMAZON_S3_BUCKET_PUBLIC_KEY`
### `AMAZON_S3_BUCKET_REGION`
### `AMAZON_S3_BUCKET_SECRET_KEY`
---
### `APP_ADMIN_EMAIL`
### `APP_ADMIN_PASSWORD`
### `APP_ASSET_DISABLE_BOOTSTRAP_BUNDLE`
### `APP_ASSET_FORCE_PUBLISH`
### `APP_ASSET_USE_BUNDLED`
### `APP_AUDIT_DISABLE_ALL_ACTIONS`
### `APP_CONFIG_FILE`
### `APP_COOKIE_VALIDATION_KEY`
### `APP_DB_DISABLE_SCHEMA_CACHE`
Wether to enable schema caching for database connections
### `APP_DEBUG_KEY`
Cookie token key for enabling `YII_DEBUG` (minimal length: 11)
### `APP_DEBUG_TOKEN`
Cookie token value for enabling `YII_DEBUG` (minimal length: 11)
### `APP_FILEFLY_DEFAULT_FILESYSTEM`
### `APP_INTERACTIVE`
### `APP_LANGUAGES`
### `APP_MAILER_ENCRYPTION`
### `APP_MAILER_FROM`
### `APP_MAILER_HOST`
### `APP_MAILER_PASSWORD`
### `APP_MAILER_PORT`
### `APP_MAILER_REPLY_TO`
### `APP_MAILER_RETURN_PATH`
### `APP_MAILER_SCHEME`
### `APP_MAILER_USE_FILE_TRANSPORT`
### `APP_MAILER_USERNAME`
### `APP_MIGRATION_LOOKUP`
### `APP_NAME`
### `APP_NO_CACHE`
### `APP_PAGES_TITLE_PREFIX`
### `APP_PARAMS_BACKEND_IFRAME_NAME`
### `APP_PRETTY_URLS`
### `APP_QUEUE_CHANNEL`
### `APP_TITLE`
### `APP_USER_ENABLE_REGISTRATION`
### `DATABASE_DSN`
### `DATABASE_PASSWORD`
### `DATABASE_TABLE_PREFIX`
### `DATABASE_USER`
---
### `DB_ENV_MYSQL_CLI_WAIT_TIMEOUT`
### `DB_ENV_MYSQL_ROOT_PASSWORD`
Development
### `DB_ENV_MYSQL_ROOT_USER`
---
### `ENV_LOCAL_FILE`
Local environment variables
---
### `FTP_BUCKET_FILESYSTEM_BASE_PATH`
### `FTP_BUCKET_HOST`
### `FTP_BUCKET_PASSWORD`
### `FTP_BUCKET_PORT`
### `FTP_BUCKET_SSL`
### `FTP_BUCKET_USER`
### `HOSTNAME`
### `HTTPS`
### `MYSQL_ATTR_SSL_CA`
### `PHP_USER_ID`
### `REDIS_PORT_6379_TCP_ADDR`
### `REDIS_PORT_6379_TCP_PORT`
### `TWIG_DEBUG_MODE`
### `YII_DEBUG`
### `YII_ENV`
### `YII_TRACE_LEVEL`


## Development

Find application environment variables in PHP code and create a raw file from them.

```
grep -ohr -P "getenv\(['\"]([A-Z0-9_]*)['\"]\)" config/ src/ web/ \
| sort -u  \
| cut -d"'" -f2 \
| awk '{ print "### `" $1 "`" }' \
> docs/configuration.md.raw
```
