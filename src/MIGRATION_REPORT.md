# Asset Migration Report

Generated: 2025-10-23 12:40:48

## Summary

- **Bower Assets**: 19
- **NPM Assets**: 19

## Migration Strategy

**Using bower directly** (native bower installation)

### Step 1: Files are already generated

The following files have been generated:
- `src/package.json` - NPM dependencies
- `src/bower.json` - Bower dependencies
- `src/assets/replaced/composer.json` - Asset replacements

### Step 2: Install bower packages

```bash
cd src
npm install  # Installs bower into node_modules
npx bower install  # Installs bower packages into bower_components
```

### Step 3: Add local asset-replacement repository and require it

Add the local path repository to `src/composer.json`:

```bash
cd src
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

Then require the local package:

```bash
composer require app/local-replaced-assets:@dev
```

This installs the local package which replaces all bower-asset/* and npm-asset/* packages.

### Step 4: Update aliases in config

Update `config/common.php` to use correct paths:

```php
'aliases' => [
    '@npm' => '@root/node_modules',
    '@bower' => '@vendor/bower_components',
],
```

**Important:** AssetBundles do NOT need to be changed! The `@npm` and `@bower` aliases point to the correct locations where npm and bower maintain the same structure as before.

### Step 5: Remove bower-asset from composer.phd5.json

Remove bower-asset dependencies from `src/composer.phd5.json`:

```json
// Remove:
"bower-asset/ace-builds": "...",
"bower-asset/bootstrap": "...",
"bower-asset/bootstrap-datepicker": "...",
// ... etc
```

### Step 6: Run composer update

```bash
cd src
composer update
```

### Step 7: Test and verify

Test all frontend functionality and asset loading.

### Step 8: Remove asset-packagist.org

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

These packages are managed via bower.json and bower-away:

| Bower Package | Version |
|---------------|----------|
| bower-asset/ace-builds | v1.15.3 |
| bower-asset/bootstrap | v3.4.1 |
| bower-asset/bootstrap-datepicker | v1.9.0 |
| bower-asset/bootstrap-daterangepicker | v3.1 |
| bower-asset/chartjs | v2.9.4 |
| bower-asset/inputmask | 5.0.8 |
| bower-asset/jquery | 3.6.4 |
| bower-asset/jquery-cookie | v1.4.1 |
| bower-asset/jquery-growl | v1.3.5 |
| bower-asset/jquery-ui | 1.12.1 |
| bower-asset/mermaid | 8.14.0 |
| bower-asset/microplugin | v0.0.3 |
| bower-asset/moment | 2.30.1 |
| bower-asset/noty | v2.4.1 |
| bower-asset/punycode | v2.3.1 |
| bower-asset/selectize | 0.12.6-patch1 |
| bower-asset/sifter | v0.5.4 |
| bower-asset/smalot-bootstrap-datetimepicker | 2.4.4 |
| bower-asset/yii2-pjax | 2.0.8 |

## NPM Assets

These packages are installed directly via npm:

| Package | Version |
|---------|----------|
| npm-asset/ace-builds | 1.43.4 |
| npm-asset/ajv | 6.12.6 |
| npm-asset/core-js | 3.45.1 |
| npm-asset/dmstr--cookie-consent | 0.4.1 |
| npm-asset/fast-deep-equal | 3.1.3 |
| npm-asset/fast-json-stable-stringify | 2.1.0 |
| npm-asset/javascript-natural-sort | 0.7.1 |
| npm-asset/jmespath | 0.16.0 |
| npm-asset/json-editor--json-editor | 2.15.2 |
| npm-asset/json-schema-traverse | 0.4.1 |
| npm-asset/json-source-map | 0.6.1 |
| npm-asset/jsoneditor | 9.10.5 |
| npm-asset/jsonrepair | 3.1.0 |
| npm-asset/mobius1-selectr | 2.4.13 |
| npm-asset/picomodal | 3.0.0 |
| npm-asset/punycode | 2.3.1 |
| npm-asset/sphinxxxx--color-conversion | 2.2.2 |
| npm-asset/uri-js | 4.4.1 |
| npm-asset/vanilla-picker | 2.12.3 |

## AssetBundles to Update

Search for these patterns and update:

```bash
# Find all AssetBundle files
find src -name '*Asset.php' -type f

# Search for bower references
grep -r '@bower' src/
grep -r 'bower-asset' src/
```

