<?php
/**
 * Migration Report View
 *
 * @var array $bowerAssets Bower assets map
 * @var array $npmAssets NPM assets map
 */

use yii\helpers\Markdown;

?>
# Asset Migration Report

Generated: <?= date('Y-m-d H:i:s') ?>


## Summary

- **Bower Assets**: <?= count($bowerAssets) ?>

- **NPM Assets**: <?= count($npmAssets) ?>


## Migration Strategy

**Using bower directly** (native bower installation)

### Step 1: Files are already generated

The following files have been generated:
- `package.json` - NPM dependencies
- `bower.json` - Bower dependencies
- `assets/replaced/composer.json` - Asset replacements

### Step 2: Manual testing of npm and bower packages

Test npm and bower installation manually:

```bash
make cli
npm --prefix=/app install /app/src/
npx bower install --allow-root       # Bower requires --allow-root flag
```

### Step 3: Add local asset-replacement repository and remove old assets

Add the local path repository to `src/composer.json`:

```bash
composer config repositories.replaced-assets path ./assets/replaced
```

This adds the following to your composer.json:

```json
"repositories": {
    "replaced-assets": {
        "type": "path",
        "url": "./assets/replaced"
    }
}
```

Remove bower-asset and npm-asset dependencies from `src/composer.phd5.json`:

```json
// Remove:
<?php foreach (array_slice($bowerAssets, 0, 3) as $name => $version): ?>
"bower-asset/<?= $name ?>": "...",
<?php endforeach; ?>
// ... etc
```

### Step 4: Verify installation

After installation, verify that assets are in the correct locations:

```bash
ls -la /app/node_modules             # NPM packages
ls -la /app/vendor/bower_components  # Bower packages
```

**Important:** No config changes needed! Assets are installed to standard locations:
- NPM packages: `/app/node_modules` (already mapped via `@root/node_modules` or `@npm`)
- Bower packages: `/app/vendor/bower_components` (already mapped via `@vendor/bower_components` or `@bower`)
- NPM-asset compatibility: Symlinks created automatically via postinstall hook

### Step 6: Install local replacement package

```bash
composer require app/local-replaced-assets:@dev
```

This installs the local package which replaces all bower-asset/* and npm-asset/* packages.

### Step 7: Test and verify

Test all frontend functionality and asset loading.

### Step 8: Apply changes to Dockerfile

Apply Dockerfile changes as documented in README.md.

### Step 9: Remove asset-packagist.org

Once all assets are migrated, remove from `src/composer.json`:

```json
"repositories": {
    // Remove:
    // "ap": {
    //     "type": "composer",
    //     "url": "https://asset-packagist.org"
    // }
}
```

## Bower Assets

These packages are managed via bower.json:

| Bower Package | Version |
|---------------|----------|
<?php foreach ($bowerAssets as $name => $version): ?>
| bower-asset/<?= $name ?> | <?= $version ?> |
<?php endforeach; ?>

## NPM Assets

These packages are installed directly via npm:

| Package | Version |
|---------|----------|
<?php foreach ($npmAssets as $name => $version): ?>
| npm-asset/<?= $name ?> | <?= $version ?> |
<?php endforeach; ?>

