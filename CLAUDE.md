# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**phd5-app** is a universal web application template built upon Docker, PHP and Yii 2.0 Framework by dmstr/diemeisterei GmbH. It provides a complete full-stack application framework with extensive module support for content management, user management, file handling, and more.

## Core Architecture

### Application Structure

- **src/**: Main application code (controllers, views, assets, commands)
- **config/**: Application configuration files split by context (common, web, console)
- **tests/**: Codeception-based test suites (e2e, functional, cli, unit)
- **docker/**: Docker Compose configuration files for different environments

### Configuration System

The application uses a multi-layered configuration approach:

1. **config/common.php**: Shared configuration for all contexts (web + console)
2. **config/web.php**: Web-specific configuration (merged with common)
3. **config/console.php**: CLI-specific configuration (merged with common)
4. **Environment Variables**: Loaded via `.env` file (created from `.env-dist`)
5. **src/composer.phd5.json**: Core PHD5 dependencies (merged via wikimedia/composer-merge-plugin)

All environment-dependent settings (database, mailer, cache, etc.) use `getenv()` to read from ENV variables.

### Key Modules

The application includes these pre-configured Yii2 modules:

- **backend**: Admin dashboard and management interface (dmstr/yii2-backend-module)
- **user**: User management, authentication, RBAC (2amigos/yii2-usuario)
- **audit**: Activity tracking and logging (bedezign/yii2-audit)
- **pages**: CMS page management with tree structure (dmstr/yii2-pages-module)
- **widgets**: Widget/template management system (hrzg/yii2-widget-module)
- **filefly**: File management with multiple filesystem support (dmstr/yii2-filefly-module)
- **prototype**: Rapid prototyping and scaffolding (dmstr/yii2-prototype-module)
- **translatemanager**: i18n translation management (lajax/yii2-translate-manager)
- **redirects**: URL redirect management (dmstr/yii2-redirect-module)
- **contact**: Contact form module (dmstr/yii2-contact-module)
- **resque**: Background job queue UI (hrzg/yii2-resque-module)

### Database Architecture

- **Primary DB (`db` component)**: Application data with configurable table prefix
- **System DB (`dbSystem` component)**: Sessions, audit logs, queue (separate from app data)
- **Translations**: Stored in database via `DbMessageSource` (tables: `language_source`, `language_translate`)
- **Migrations**: Multiple paths configured in console.php for all modules

### Multi-Language Support

Languages are configured via `APP_LANGUAGES` ENV variable (comma-separated). The application uses:
- `codemix/yii2-localeurls` for URL-based language switching
- `DbMessageSource` for all translations with caching
- `TranslateableBehavior` from 2amigos for model translations
- Fallback language configured via `APP_FALLBACK_LANGUAGE`

## Common Development Tasks

### Setup and Initialization

```bash
# Full setup (first time)
make all

# Start services
make up

# Run application setup (creates DB, admin user)
make bash
$ yii app/setup

# View all available make targets
make help
```

### Development Workflow

```bash
# Access PHP container bash
make bash

# Run Yii console commands from container
$ yii <command>

# Open application in browser
make browser

# View logs
make logs
```

### Database Operations

```bash
# Create database (if not exists)
$ yii db/create

# Run migrations
$ yii migrate/up

# Create database dump (excludes system tables)
$ yii db/x/dump
```

### Testing

```bash
# Run all tests
make test

# Run tests with coverage
make test-coverage

# Debug tests in container
make test-bash
$ codecept run -d

# Run specific test suite
$ codecept run e2e
$ codecept run functional
$ codecept run cli
$ codecept run unit
```

Test configuration is in `tests/codeception.yml` with suites in `tests/codeception/`.

### Code Quality

```bash
# Fix code style issues
make fix-source

# Check code style (dry-run)
make lint-source

# Run all linting (source + metrics + composer)
make lint

# Validate composer.json
$ composer validate -dsrc
```

Uses `friendsofphp/php-cs-fixer` for PSR-12 code style enforcement.

### Asset Management

```bash
# Build/compress asset bundles
make assets

# Clear generated assets
$ yii app/clear-assets
```

Asset bundling is configured in `config/assets.php`. Control via `APP_ASSET_USE_BUNDLED` ENV variable.

### Package Management

```bash
# Install PHP dependencies
make install

# Update packages (respects composer.lock)
make upgrade

# Full dist-upgrade (rebuild + update)
make dist-upgrade
```

The composer setup uses a **merge plugin** to combine `src/composer.json` with `src/composer.phd5.json`.

### Module Management

When adding migrations for custom modules, add the migration path to `config/console.php` under the `migrate` controller configuration:

```php
'migrationPath' => \yii\helpers\ArrayHelper::merge(
    explode(',', getenv('APP_MIGRATION_LOOKUP')),
    [
        // ... existing paths
        '@app/modules/yourmodule/migrations',
    ]
),
```

## Docker Architecture

The application uses docker-compose with multiple compose files for different purposes:

- **docker-compose.yml**: Base services (php, db, redis)
- **docker/docker-compose.dev.yml**: Development tools (mailcatcher, etc.)
- **docker/docker-compose.test.yml**: Test environment
- **docker/docker-compose.selenium.yml**: Browser testing

Services can be configured via `COMPOSE_FILE` in `.env`.

## Important Conventions

### Controllers

- Business logic belongs in models or components (fat-model pattern)
- Use `$this->request` / `$this->response` instead of `Yii::$app->request`
- Prefer REST controllers (`yii\rest\Controller`) for APIs
- Data-modifying requests must be POST/PUT/DELETE (never GET)

### Models

- Always extend base rules/scenarios from parent: `$rules = parent::rules();`
- Add meaningful array indexes for new rules
- Use public constants for scenario names
- Validation belongs in models, not controllers/components
- Separate Form Models (`models/forms/`) from ActiveRecord Models
- Use custom abstract base ActiveRecord with `TimestampBehavior` and `AuditTrailBehavior`

### Migrations

- Use `datetime()` for created_at/updated_at fields
- Prefer UUID as primary keys where possible
- Use `LONGTEXT` for JSON fields
- Date format in filenames: `mYYMMDD_HHMMSS_description.php`
- Timezone: Europe/Berlin

### RBAC

Use `dmstr/yii2-rbac-migration` package for permission/role migrations. Core roles:
- **Default**: Base role for all authenticated users
- **Guest**: Unauthenticated users
- **Public**: Child of Default and Guest (for public content)
- **Editor**: Content editors
- **Master**: Full administrative access

### URL Management

- Use `Url::to()` or route aliases (never hardcode URLs)
- Pretty URLs controlled via `APP_PRETTY_URLS` ENV variable
- Language-specific URLs handled automatically by `localeurls`

## Environment Variables Reference

Key ENV variables (see `.env-dist` for full list):

- **APP_NAME**: Application identifier
- **APP_TITLE**: Human-readable application name
- **APP_LANGUAGES**: Comma-separated language codes (e.g., "en,de")
- **APP_ADMIN_EMAIL**: Administrator email
- **DATABASE_DSN**: Database connection string
- **DATABASE_TABLE_PREFIX**: Table prefix for app tables
- **REDIS_PORT_6379_TCP_ADDR**: Redis host
- **APP_PRETTY_URLS**: Enable/disable pretty URLs (0/1)
- **YII_ENV**: Application environment (dev/test/prod)
- **YII_DEBUG**: Enable debug mode (0/1)

## Application Commands

Custom console commands in `src/commands/AppController.php`:

- **yii app/version**: Display application version
- **yii app/setup**: Initialize application (DB + admin user)
- **yii app/config [key]**: Display configuration
- **yii app/env**: Show environment variables
- **yii app/cleanup**: Clear cache, assets, old audit logs
- **yii app/clear-assets**: Remove generated web assets
- **yii app/test-mail <email>**: Send test email

## Version History

Current branch typically follows `master` for main development. See `UPGRADING.md` for version-specific migration notes when upgrading from older versions (5.x series).

## Additional Resources

- Documentation: https://github.com/dmstr/phd5-docs
- Template project: https://github.com/dmstr/phd5-template
- Using as base image: See phd5-template repository
