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
- Generates `assets/replaced/composer.json` - Local Composer package that replaces all asset packages
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
- `assets/replaced/composer.json` - Local replacement package
- `MIGRATION_REPORT.md` - Detailed migration instructions

### 4. Follow the migration steps

See the generated `MIGRATION_REPORT.md` for detailed step-by-step instructions.

## Manual Changes Required

### 1. Dockerfile

Update your Dockerfile to install NPM and Bower packages:

```dockerfile
# NPM and Bower packages for frontend assets
COPY src/package.json src/bower.json src/.bowerrc /app/src/
RUN if [ -z "$BUILD_NO_INSTALL" ] && [ -f /app/src/package.json ]; then \
        cd /app/src && \
        npm --prefix=/app i /app/src/ && \
        npx bower install --allow-root && \
        npm cache clean --force; \
    fi
```

**Important notes:**
- `npm --prefix=/app` installs to `/app/node_modules`
- `postinstall` hook runs automatically after npm install
- Bower uses `.bowerrc` to install to `/app/vendor/bower_components`

### 2. .bowerrc

Create `src/.bowerrc` to specify bower installation directory:

```json
{
  "directory": "/app/vendor/bower_components"
}
```

### 3. composer.json

Add the local replacement package repository and require it:

```bash
cd src
composer config repositories.replaced-assets path ./assets/replaced
composer require app/local-replaced-assets:@dev
```

This adds:

```json
{
    "repositories": {
        "replaced-assets": {
            "type": "path",
            "url": "./assets/replaced"
        }
    },
    "require": {
        "app/local-replaced-assets": "@dev"
    }
}
```

### 4. Remove asset-packagist (optional)

Once migration is complete and tested, you can remove asset-packagist from your repositories:

```bash
cd src
composer config --unset repositories.asset-packagist
```

## Configuration

### Asset Paths

Assets are installed to standard locations that work with existing Yii alias configuration:

- **NPM packages**: `/app/node_modules`
  - Mapped via `@root/node_modules` or `@npm` alias

- **Bower packages**: `/app/vendor/bower_components`
  - Mapped via `@vendor/bower_components` or `@bower` alias

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
