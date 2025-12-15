# Asset Migration Tool

A Yii 2 console command to migrate from asset-packagist managed bower/npm assets to native Bower and NPM package management.

## Why?

### Problems with asset-packagist.org

- **Outdated packages**: Asset-packagist is often not up-to-date with the latest versions
- **Maintenance issues**: The service has had reliability problems
- **Yii 2.2 preparation**: Yii 2.2 drops built-in asset-packagist support

### Solution

This tool helps you migrate to native Bower and NPM package management:

- **Bower packages** are installed directly via `bower install`
- **NPM packages** are installed directly via `npm install`
- **Composer replacements** prevent conflicts using a local replacement package
- **Backward compatibility** is maintained through symlinks and proper path configuration

## What does it do?

The Asset Migration Tool has two commands:

### `analyze` (default)
- Analyzes your `composer.lock` to find all `bower-asset/*` and `npm-asset/*` dependencies
- Generates `MIGRATION_REPORT.md` with detailed migration guide
- Displays summary of found assets

### `generate`
- Does everything `analyze` does, plus:
- Generates `package.json` - NPM dependencies with postinstall hook for symlink creation
- Generates `bower.json` - Bower dependencies with version constraints
- Generates `composer.replaced-assets.json` - Local Composer package that replaces all asset packages
- Asks for confirmation before overwriting existing files

### Local Replacement Package

The tool **creates a local replacement package** (`app/local-replaced-assets`) that:
- Uses Composer's `replace` directive to satisfy asset package requirements
- Gets tracked in `composer.lock` like any other package
- Allows you to remove asset-packagist from your repositories

### Automatic Compatibility

The tool **sets up automatic compatibility**:
- NPM postinstall hook creates symlinks from npm-asset naming to real NPM package names
- Example: `json-editor--json-editor` → `@json-editor/json-editor`
- This ensures existing AssetBundles continue to work without modifications

## Configuration

Add the controller to your console configuration (`config/console.php`):

```php
return [
    'controllerMap' => [
        'asset-migration' => \dmstr\cramer\commands\AssetMigrationController::class,
    ],
    // ... rest of config
];
```

### Manual Installation (Optional)

If you want to use this tool without installing it via Composer (e.g., during development or testing), add the namespace alias to your configuration:

```php
return [
    'aliases' => [
        'dmstr/cramer' => '@app/extensions/dmstr/cramer',
    ],
    'controllerMap' => [
        'asset-migration' => \dmstr\cramer\commands\AssetMigrationController::class,
    ],
    // ... rest of config
];
```

**Note:** This is only required for manual installation. If you install the package via Composer, the alias is automatically configured through PSR-4 autoloading.

### Custom Configuration

You can customize the default behavior:

```php
'controllerMap' => [
    'asset-migration' => [
        'class' => \dmstr\cramer\commands\AssetMigrationController::class,
        'outputPath' => '@app/debug',           // Custom output directory
        'composerLockFile' => '@root/composer.lock', // Custom composer.lock path
    ],
],
```

## Usage

### 1. Run the analyzer

```bash
./yii asset-migration
```

This analyzes your composer.lock and generates a migration report.

### 2. Generate migration files

```bash
./yii asset-migration/generate
```

This generates all necessary files and asks for confirmation before overwriting existing files.

### Options

- `--outputPath=/path` or `-o /path` - Directory for generated files (default: `@app`)
- `--composerLockFile=/path` - Path to composer.lock file (default: `@root/src/composer.lock`)

### Examples

```bash
# Analyze with default paths
./yii asset-migration

# Analyze custom composer.lock
./yii asset-migration --composerLockFile=/custom/path/composer.lock

# Generate files to debug directory
./yii asset-migration/generate -o /debug

# Generate from custom composer.lock to custom output
./yii asset-migration/generate --composerLockFile=/custom/composer.lock -o /debug
```

### 3. Review generated files

Check the generated files (location depends on `--outputPath`):
- `package.json` - Contains NPM dependencies and postinstall hook
- `bower.json` - Contains Bower dependencies
- `.bowerrc` - Bower configuration (install directory)
- `assets-replaced/composer.json` - Local replacement package (in its own directory for Composer path repository)
- `MIGRATION_REPORT.md` - Detailed migration instructions

### 4. Follow the migration steps

See the generated `MIGRATION_REPORT.md` for detailed step-by-step instructions.

## Manual Changes Required

### 1. Dockerfile

Update your Dockerfile to install NPM and Bower packages and copy the assets-replaced directory.

```dockerfile
# Copy assets-replaced directory for Composer path repository
COPY project/assets-replaced /app/project/assets-replaced

# NPM and Bower packages for frontend assets
COPY project/package.json project/bower.json project/.bowerrc /app/project/
RUN if [ -z "$BUILD_NO_INSTALL" ] && [ -f /app/project/package.json ]; then \
        cd /app/project && \
        npm --prefix=/app i /app/project/ && \
        npx bower install --allow-root && \
        npm cache clean --force; \
    fi
```

**Important notes:**
- `npm --prefix=/app` installs to `/app/node_modules`
- `postinstall` hook runs automatically after npm install
- Bower uses `.bowerrc` to install to `/app/vendor/bower-asset` (for compatibility with Yii asset aliases)

### 2. .bowerrc

The `.bowerrc` file is automatically generated by the `generate` command. It configures Bower to install packages to `/app/vendor/bower-asset` for compatibility with Yii asset aliases.

### 3. composer.json

Add the local replacement package repository and require it:

```bash
cd project
composer config repositories.replaced-assets path ./assets-replaced
composer require app/local-replaced-assets:@dev
```

The `assets-replaced/` directory is automatically created by the `generate` command with the proper `composer.json` inside.

This adds:

```json
{
    "repositories": {
        "replaced-assets": {
            "type": "path",
            "url": "./assets-replaced"
        }
    },
    "require": {
        "app/local-replaced-assets": "@dev"
    }
}
```

Once migration is complete and tested, you can remove asset-packagist from your repositories:

```bash
cd project
composer config --unset repositories.asset-packagist
```

### 4. Makefile

Update your `make install` target to include NPM and Bower installation:

```makefile
install:
	$(DOCKER_COMPOSE) run --rm $(PHP_SERVICE) composer install
	$(DOCKER_COMPOSE) run --rm php npm --prefix=/app i /app/project/
	$(DOCKER_COMPOSE) run --rm -w /app/project php npx bower install --allow-root
```

## Configuration

### Asset Paths

Assets are installed to standard locations that work with existing Yii alias configuration:

- **NPM packages**: `/app/node_modules`
  - Mapped via `@root/node_modules` or `@npm` alias

- **Bower packages**: `/app/vendor/bower-asset`
  - Mapped via `@vendor/bower-asset` or `@bower` alias
  - Uses `bower-asset` directory name for Yii compatibility (matches asset-packagist convention)

- **NPM-asset compatibility**: Symlinks created automatically
  - Example: `/app/node_modules/json-editor--json-editor` → `/app/node_modules/@json-editor/json-editor`

### No AssetBundle Changes Needed

Thanks to the automatic symlink creation, your existing AssetBundles continue to work without modifications:

```php
// This continues to work:
public $sourcePath = '@npm/json-editor--json-editor/dist';

// Because a symlink exists:
// /app/node_modules/json-editor--json-editor -> @json-editor/json-editor
```

## Helper Script

The tool installs a helper script to `/usr/local/bin/create-npm-asset-symlinks` that:

- Scans `/app/node_modules` for scoped packages (starting with `@`)
- Creates symlinks using npm-asset naming convention
- Runs automatically via npm postinstall hook
- Can be run manually if needed: `create-npm-asset-symlinks /path/to/node_modules`

## Troubleshooting

### No assets found

If the analyzer reports "No bower-asset or npm-asset packages found", you've either:
- Already completed the migration
- Don't have any asset-packagist dependencies
- Need to check your `composer.lock` file

### Bower version conflicts

If bower can't find a specific version, check:
- The package may have been renamed (e.g., `bootstrap-daterangepicker` → `daterangepicker`)
- The version may not exist in the bower registry
- Manually adjust the version in `bower.json`

### Symlinks not created

If npm-asset compatibility symlinks aren't created:
- Ensure `/usr/local/bin/create-npm-asset-symlinks` is executable
- Check that the postinstall hook runs (look for output during `npm install`)
- Run manually: `create-npm-asset-symlinks /app/node_modules`

## Migration Strategy

This tool follows the **"local replacement package"** approach:

1. **Assets installed natively**: Bower and NPM manage their respective packages
2. **Composer satisfaction**: Local package uses `replace` directive to satisfy dependencies
3. **Lock file tracking**: Everything is tracked in `composer.lock`
4. **Backward compatibility**: Symlinks maintain compatibility with existing code
5. **No manual updates**: AssetBundles don't need to be changed

This is different from asset-packagist which installed everything via Composer.

## Credits

Developed by herzog kommunikation GmbH for phd5-app.

Part of the migration path from Yii 2.0 to Yii 2.2.
