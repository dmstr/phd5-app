<?php

namespace dmstr\cramer\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Json;

/**
 * Asset Migration Tool
 *
 * Analyzes bower-asset and npm-asset dependencies from composer.lock
 * and generates migration plan to native NPM packages using bower-away.
 *
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2025 diemeisterei GmbH, Stuttgart
 */
class AssetMigrationController extends Controller
{
    /**
     * @var string Output directory for generated files
     */
    public $outputDir = '@app';

    /**
     * @var bool Generate package.json template
     */
    public $generatePackageJson = true;

    /**
     * @var bool Use bower directly (no bower-away conversion)
     */
    public $useBower = true;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['outputDir', 'generatePackageJson', 'useBower']
        );
    }

    /**
     * Confirms file overwrite with user
     *
     * @param string $filePath Path to the file
     * @return bool True if user confirms or file doesn't exist, false otherwise
     */
    protected function confirmFileWrite($filePath)
    {
        if (!file_exists($filePath)) {
            return true;
        }

        $this->stdout("\nFile already exists: $filePath\n", \yii\helpers\Console::FG_YELLOW);
        return $this->confirm('Overwrite?', false);
    }

    /**
     * Analyzes current asset dependencies and generates migration plan
     *
     * Usage:
     *   yii asset-migration/analyze
     *   yii asset-migration/analyze --outputDir=/debug
     *   yii asset-migration/analyze --useBower=0  (disable bower, use native NPM)
     */
    public function actionAnalyze()
    {
        $this->stdout("\n=== Asset Migration Analyzer ===\n\n", \yii\helpers\Console::BOLD);

        $composerLock = Yii::getAlias('@root/src/composer.lock');

        if (!file_exists($composerLock)) {
            $this->stderr("ERROR: composer.lock not found at $composerLock\n");
            return self::EXIT_CODE_ERROR;
        }

        $lockData = Json::decode(file_get_contents($composerLock));

        // Extract bower and npm assets
        $bowerAssets = $this->extractAssets($lockData, 'bower-asset/');
        $npmAssets = $this->extractAssets($lockData, 'npm-asset/');

        $this->stdout("Found Bower Assets: " . count($bowerAssets) . "\n", \yii\helpers\Console::FG_GREEN);
        $this->stdout("Found NPM Assets: " . count($npmAssets) . "\n\n", \yii\helpers\Console::FG_GREEN);

        // Exit early if no assets found
        if (empty($bowerAssets) && empty($npmAssets)) {
            $this->stdout("No bower-asset or npm-asset packages found in composer.lock.\n", \yii\helpers\Console::FG_YELLOW);
            $this->stdout("Nothing to migrate!\n\n", \yii\helpers\Console::FG_GREEN);
            return self::EXIT_CODE_NORMAL;
        }

        // Display bower assets
        $this->stdout("Bower Assets:\n", \yii\helpers\Console::BOLD);
        $this->stdout(str_repeat('-', 80) . "\n");
        foreach ($bowerAssets as $name => $version) {
            $this->stdout(sprintf("  %-35s %15s\n", $name, $version));
        }

        $this->stdout("\n");

        // Display npm assets
        $this->stdout("NPM Assets:\n", \yii\helpers\Console::BOLD);
        $this->stdout(str_repeat('-', 80) . "\n");
        foreach ($npmAssets as $name => $version) {
            $this->stdout(sprintf("  %-35s %15s\n", $name, $version));
        }

        $this->stdout("\n");

        // Generate migration files
        if ($this->generatePackageJson) {
            $this->generatePackageJsonTemplate($bowerAssets, $npmAssets);
        }

        $this->generateMigrationReport($bowerAssets, $npmAssets);

        if ($this->useBower) {
            $this->generateBowerJson($bowerAssets);
        }

        $this->generateComposerAssets($bowerAssets, $npmAssets);

        $this->stdout("\n✓ Analysis complete!\n\n", \yii\helpers\Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Extracts asset packages from composer.lock data
     *
     * @param array $lockData Parsed composer.lock data
     * @param string $prefix Package name prefix (e.g., 'bower-asset/')
     * @return array Map of package name => version
     */
    protected function extractAssets($lockData, $prefix)
    {
        $assets = [];

        if (!isset($lockData['packages'])) {
            return $assets;
        }

        foreach ($lockData['packages'] as $package) {
            if (isset($package['name']) && strpos($package['name'], $prefix) === 0) {
                $name = str_replace($prefix, '', $package['name']);
                $version = $package['version'] ?? 'unknown';
                $assets[$name] = $version;
            }
        }

        ksort($assets);
        return $assets;
    }

    /**
     * Generates package.json template
     *
     * @param array $bowerAssets Bower assets map (NOT used when useBower=true)
     * @param array $npmAssets NPM assets map
     */
    protected function generatePackageJsonTemplate($bowerAssets, $npmAssets)
    {
        $dependencies = [];

        if (!$this->useBower) {
            // Native NPM approach: Convert bower assets to NPM equivalents
            foreach ($bowerAssets as $name => $version) {
                $npmVersion = $this->convertVersionToNpm($version);
                $dependencies[$name] = $npmVersion;
            }
        }
        // When using bower: Bower packages are handled via bower.json, not package.json
        // But add real NPM packages, converting npm-asset naming to real npm names
        foreach ($npmAssets as $name => $version) {
            // Convert npm-asset naming convention:
            // "json-editor--json-editor" -> "@json-editor/json-editor"
            // "dmstr--cookie-consent" -> "@dmstr/cookie-consent"
            if (strpos($name, '--') !== false) {
                // This is a scoped package
                $cleanName = '@' . str_replace('--', '/', $name);
            } else {
                // Regular unscoped package
                $cleanName = $name;
            }

            if (!isset($dependencies[$cleanName])) {
                $npmVersion = $this->convertVersionToNpm($version);
                $dependencies[$cleanName] = $npmVersion;
            }
        }

        ksort($dependencies);

        $packageJson = [
            'name' => 'phd5-app',
            'version' => '1.0.0',
            'description' => 'Frontend assets for phd5-app',
            'private' => true,
            'dependencies' => $dependencies,
            'devDependencies' => [
                'less' => '^4.2.0',
            ],
            'scripts' => [
                'postinstall' => '/usr/local/bin/create-npm-asset-symlinks /app/node_modules'
            ]
        ];

        // Add bower configuration if enabled
        if ($this->useBower) {
            $packageJson['devDependencies']['bower'] = '^1.8.14';
        }

        $packageJsonFile = Yii::getAlias('@app/package.json');

        if (!$this->confirmFileWrite($packageJsonFile)) {
            $this->stdout("Skipped: $packageJsonFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        file_put_contents($packageJsonFile, Json::encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->stdout("✓ Generated: $packageJsonFile\n", \yii\helpers\Console::FG_GREEN);
    }

    /**
     * Converts composer version format to NPM version format
     *
     * @param string $composerVersion Composer version string
     * @return string NPM version string
     */
    protected function convertVersionToNpm($composerVersion)
    {
        // Remove 'v' prefix
        $version = ltrim($composerVersion, 'v');

        // Convert dev-master to latest
        if (strpos($version, 'dev-') === 0) {
            return 'latest';
        }

        // Extract semver if possible
        if (preg_match('/^(\d+\.\d+\.\d+)/', $version, $matches)) {
            return '^' . $matches[1];
        }

        return $version;
    }

    /**
     * Generates detailed migration report
     *
     * @param array $bowerAssets Bower assets map
     * @param array $npmAssets NPM assets map
     */
    protected function generateMigrationReport($bowerAssets, $npmAssets)
    {
        $outputDir = Yii::getAlias($this->outputDir);
        $reportFile = $outputDir . '/MIGRATION_REPORT.md';

        $report = "# Asset Migration Report\n\n";
        $report .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";

        $report .= "## Summary\n\n";
        $report .= "- **Bower Assets**: " . count($bowerAssets) . "\n";
        $report .= "- **NPM Assets**: " . count($npmAssets) . "\n\n";

        $report .= "## Migration Strategy\n\n";

        if ($this->useBower) {
            $report .= "**Using bower directly** (native bower installation)\n\n";

            $report .= "### Step 1: Files are already generated\n\n";
            $report .= "The following files have been generated:\n";
            $report .= "- `src/package.json` - NPM dependencies\n";
            $report .= "- `src/bower.json` - Bower dependencies\n";
            $report .= "- `src/assets/replaced/composer.json` - Asset replacements\n\n";

            $report .= "### Step 2: Install bower packages\n\n";
            $report .= "```bash\n";
            $report .= "cd src\n";
            $report .= "npm install  # Installs bower into node_modules\n";
            $report .= "npx bower install  # Installs bower packages into bower_components\n";
            $report .= "```\n\n";

            $report .= "### Step 3: Add local asset-replacement repository and require it\n\n";
            $report .= "Add the local path repository to `src/composer.json`:\n\n";
            $report .= "```bash\n";
            $report .= "cd src\n";
            $report .= "composer config repositories.replaced-assets path ./assets/replaced\n";
            $report .= "```\n\n";

            $report .= "This adds the following to your composer.json:\n\n";
            $report .= "```json\n";
            $report .= "\"repositories\": {\n";
            $report .= "    \"replaced-assets\": {\n";
            $report .= "        \"type\": \"path\",\n";
            $report .= "        \"url\": \"./assets/replaced\"\n";
            $report .= "    }\n";
            $report .= "}\n";
            $report .= "```\n\n";

            $report .= "Then require the local package:\n\n";
            $report .= "```bash\n";
            $report .= "composer require app/local-replaced-assets:@dev\n";
            $report .= "```\n\n";

            $report .= "This installs the local package which replaces all bower-asset/* and npm-asset/* packages.\n\n";

            $report .= "### Step 4: Update aliases in config\n\n";
            $report .= "Update `config/common.php` to use correct paths:\n\n";
            $report .= "```php\n";
            $report .= "'aliases' => [\n";
            $report .= "    '@npm' => '@root/node_modules',\n";
            $report .= "    '@bower' => '@vendor/bower_components',\n";
            $report .= "],\n";
            $report .= "```\n\n";

            $report .= "**Important:** AssetBundles do NOT need to be changed! ";
            $report .= "The `@npm` and `@bower` aliases point to the correct locations ";
            $report .= "where npm and bower maintain the same structure as before.\n\n";

        } else {
            $report .= "**Using native NPM approach** (requires AssetBundle updates)\n\n";

            $report .= "### Step 1: Create package.json\n\n";
            $report .= "Copy `package.json.template` to `src/package.json` and review all versions.\n\n";

            $report .= "### Step 2: Install NPM packages\n\n";
            $report .= "```bash\n";
            $report .= "cd src\n";
            $report .= "npm install\n";
            $report .= "```\n\n";

            $report .= "### Step 3: Update AssetBundle configurations\n\n";
            $report .= "Update all AssetBundle classes to use NPM packages instead of bower-asset:\n\n";
            $report .= "```php\n";
            $report .= "// Before:\n";
            $report .= "public \$sourcePath = '@bower/bootstrap/dist';\n\n";
            $report .= "// After:\n";
            $report .= "public \$sourcePath = '@npm/bootstrap/dist';\n";
            $report .= "// or\n";
            $report .= "public \$js = ['@npm/jquery/dist/jquery.min.js'];\n";
            $report .= "```\n\n";

            $report .= "### Step 4: Update aliases in config\n\n";
            $report .= "Add NPM alias to `config/common.php`:\n\n";
            $report .= "```php\n";
            $report .= "'aliases' => [\n";
            $report .= "    '@npm' => '@app/node_modules',\n";
            $report .= "    '@bower' => '@vendor/bower-asset', // Keep temporarily\n";
            $report .= "],\n";
            $report .= "```\n\n";
        }

        $report .= "### Step 5: Remove bower-asset from composer.phd5.json\n\n";
        $report .= "Remove bower-asset dependencies from `src/composer.phd5.json`:\n\n";
        $report .= "```json\n";
        $report .= "// Remove:\n";
        foreach (array_slice($bowerAssets, 0, 3) as $name => $version) {
            $report .= "\"bower-asset/$name\": \"...\",\n";
        }
        $report .= "// ... etc\n";
        $report .= "```\n\n";

        $report .= "### Step 6: Run composer update\n\n";
        $report .= "```bash\n";
        $report .= "cd src\n";
        $report .= "composer update\n";
        $report .= "```\n\n";

        $report .= "### Step 7: Test and verify\n\n";
        $report .= "Test all frontend functionality and asset loading.\n\n";

        $report .= "### Step 8: Remove asset-packagist.org\n\n";
        $report .= "Once all assets are migrated, remove from `src/composer.json`:\n\n";
        $report .= "```json\n";
        $report .= "\"repositories\": {\n";
        $report .= "    // Remove:\n";
        $report .= "    // \"ap\": {\n";
        $report .= "    //     \"type\": \"composer\",\n";
        $report .= "    //     \"url\": \"https://asset-packagist.org\"\n";
        $report .= "    // }\n";
        $report .= "}\n";
        $report .= "```\n\n";

        $report .= "## Bower Assets\n\n";
        $report .= "These packages are managed via bower.json and bower-away:\n\n";
        $report .= "| Bower Package | Version |\n";
        $report .= "|---------------|----------|\n";

        foreach ($bowerAssets as $name => $version) {
            $report .= "| bower-asset/$name | $version |\n";
        }

        $report .= "\n## NPM Assets\n\n";
        $report .= "These packages are installed directly via npm:\n\n";
        $report .= "| Package | Version |\n";
        $report .= "|---------|----------|\n";

        foreach ($npmAssets as $name => $version) {
            $report .= "| npm-asset/$name | $version |\n";
        }

        $report .= "\n## AssetBundles to Update\n\n";
        $report .= "Search for these patterns and update:\n\n";
        $report .= "```bash\n";
        $report .= "# Find all AssetBundle files\n";
        $report .= "find src -name '*Asset.php' -type f\n\n";
        $report .= "# Search for bower references\n";
        $report .= "grep -r '@bower' src/\n";
        $report .= "grep -r 'bower-asset' src/\n";
        $report .= "```\n\n";

        if (!$this->confirmFileWrite($reportFile)) {
            $this->stdout("Skipped: $reportFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        file_put_contents($reportFile, $report);

        $this->stdout("✓ Generated: $reportFile\n", \yii\helpers\Console::FG_GREEN);
    }

    /**
     * Generates bower.json for direct bower installation
     *
     * @param array $bowerAssets Bower assets map
     */
    protected function generateBowerJson($bowerAssets)
    {
        $outputDir = Yii::getAlias($this->outputDir);
        $bowerJsonFile = $outputDir . '/bower.json';

        $dependencies = [];
        foreach ($bowerAssets as $name => $version) {
            // Convert composer version to bower format
            $bowerVersion = $this->convertVersionToBower($version);
            $dependencies[$name] = $bowerVersion;
        }

        $bowerJson = [
            'name' => 'phd5-app-bower',
            'private' => true,
            'dependencies' => $dependencies
        ];

        if (!$this->confirmFileWrite($bowerJsonFile)) {
            $this->stdout("Skipped: $bowerJsonFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        file_put_contents($bowerJsonFile, Json::encode($bowerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->stdout("✓ Generated: $bowerJsonFile\n", \yii\helpers\Console::FG_GREEN);
        $this->stdout("  (Install with: npx bower install)\n", \yii\helpers\Console::FG_YELLOW);
    }

    /**
     * Converts composer version format to Bower version format
     *
     * @param string $composerVersion Composer version string
     * @return string Bower version string with ^ prefix
     */
    protected function convertVersionToBower($composerVersion)
    {
        // Remove 'v' prefix
        $version = ltrim($composerVersion, 'v');

        // Extract semver if possible
        if (preg_match('/^(\d+\.\d+\.\d+)/', $version, $matches)) {
            return '^' . $matches[1];
        }

        // Return with ^ prefix for other formats
        return '^' . $version;
    }

    /**
     * Generates composer.json with replace directives in assets/replaced directory
     *
     * @param array $bowerAssets Bower assets map
     * @param array $npmAssets NPM assets map
     */
    protected function generateComposerAssets($bowerAssets, $npmAssets)
    {
        $assetsDir = Yii::getAlias('@app/assets/replaced');

        // Create directory if it doesn't exist
        if (!is_dir($assetsDir)) {
            if (!mkdir($assetsDir, 0775, true) && !is_dir($assetsDir)) {
                $this->stderr("ERROR: Could not create directory: $assetsDir\n");
                return;
            }
        }

        $composerAssetsFile = $assetsDir . '/composer.json';

        $replace = [];

        // Add all bower assets to replace
        foreach ($bowerAssets as $name => $version) {
            $replace['bower-asset/' . $name] = '*';
        }

        // Add all npm assets to replace
        foreach ($npmAssets as $name => $version) {
            $replace['npm-asset/' . $name] = '*';
        }

        ksort($replace);

        $composerAssets = [
            'name' => 'app/local-replaced-assets',
            'description' => 'Asset package replacements for phd5-app (native bower approach)',
            'type' => 'library',
            'replace' => $replace
        ];

        if (!$this->confirmFileWrite($composerAssetsFile)) {
            $this->stdout("Skipped: $composerAssetsFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        file_put_contents($composerAssetsFile, Json::encode($composerAssets, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->stdout("✓ Generated: $composerAssetsFile\n", \yii\helpers\Console::FG_GREEN);
        $this->stdout("  (Run 'composer update' to apply changes)\n", \yii\helpers\Console::FG_YELLOW);
    }
}
