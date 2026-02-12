# Asset Migration Report

Generated: 2025-12-17 13:03:23

## Summary

- **Bower Assets**: 18
- **NPM Assets**: 19

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
"bower-asset/ace-builds": "...",
"bower-asset/bootstrap": "...",
"bower-asset/bootstrap-datepicker": "...",
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
| bower-asset/ace-builds | v1.15.3 |
| bower-asset/bootstrap | v3.4.1 |
| bower-asset/bootstrap-datepicker | v1.9.0 |
| bower-asset/bootstrap-daterangepicker | v3.1 |
| bower-asset/chartjs | v2.9.4 |
| bower-asset/inputmask | 5.0.9 |
| bower-asset/jquery | 3.7.1 |
| bower-asset/jquery-cookie | v1.4.1 |
| bower-asset/jquery-growl | v1.3.5 |
| bower-asset/jquery-ui | 1.12.1 |
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
| npm-asset/ace-builds | 1.43.5 |
| npm-asset/ajv | 6.12.6 |
| npm-asset/core-js | 3.47.0 |
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

