<?php

namespace dmstr\cramer\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Json;

/**
 * Asset Migration Tool
 *
 * Analyzes bower-asset and npm-asset dependencies from composer.lock
 * and generates migration plan to native bower and NPM packages.
 *
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2025 diemeisterei GmbH, Stuttgart
 */
class AssetMigrationController extends Controller
{
    /**
     * @var string The default action of this controller
     */
    public $defaultAction = 'analyze';

    /**
     * @var string Output directory for generated files
     */
    public $outputPath = '@app';

    /**
     * @var string Path to composer.lock file
     */
    public $composerLockFile = '@root/src/composer.lock';

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['outputPath', 'composerLockFile']
        );
    }

    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return array_merge(
            parent::optionAliases(),
            ['o' => 'outputPath', 'c' => 'composerLockFile']
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
     * Analyzes current asset dependencies and generates migration report
     *
     * Usage:
     *   yii asset-migration/analyze
     *   yii asset-migration/analyze --outputPath=@app
     *   yii asset-migration/analyze -o /debug
     */
    public function actionAnalyze()
    {
        $this->stdout("\n=== Asset Migration Analyzer ===\n\n", \yii\helpers\Console::BOLD);

        $composerLock = Yii::getAlias($this->composerLockFile);

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

        // Generate migration report only
        $this->generateMigrationReport($bowerAssets, $npmAssets);

        $this->stdout("\n✓ Analysis complete!\n\n", \yii\helpers\Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Generates all migration files (package.json, bower.json, composer.json)
     *
     * Usage:
     *   yii asset-migration/generate
     *   yii asset-migration/generate --outputPath=@app
     *   yii asset-migration/generate -o /debug
     */
    public function actionGenerate()
    {
        $this->stdout("\n=== Asset Migration Generator ===\n\n", \yii\helpers\Console::BOLD);

        $composerLock = Yii::getAlias($this->composerLockFile);

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

        // Generate all migration files
        $this->generatePackageJsonTemplate($bowerAssets, $npmAssets);
        $this->generateYarnrc();
        $this->generateYarnLock();
        $this->generateMigrationReport($bowerAssets, $npmAssets);
        $this->generateBowerJson($bowerAssets);
        $this->generateBowerrc();
        $this->generateComposerAssets($bowerAssets, $npmAssets);

        $this->stdout("\n✓ Generation complete!\n\n", \yii\helpers\Console::FG_GREEN);

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
     * @param array $bowerAssets Bower assets map (not used, handled via bower.json)
     * @param array $npmAssets NPM assets map
     */
    protected function generatePackageJsonTemplate($bowerAssets, $npmAssets)
    {
        $dependencies = [];

        // Bower packages are handled via bower.json, not package.json
        // Add real NPM packages, converting npm-asset naming to real npm names
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
                'bower' => '^1.8.14',
            ],
            'scripts' => [
                'postinstall' => '/usr/local/bin/create-npm-asset-symlinks /app/node_modules'
            ]
        ];

        $outputDir = Yii::getAlias($this->outputPath);
        $packageJsonFile = $outputDir . '/package.json';

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
        $outputDir = Yii::getAlias($this->outputPath);
        $reportFile = $outputDir . '/MIGRATION_REPORT.md';

        if (!$this->confirmFileWrite($reportFile)) {
            $this->stdout("Skipped: $reportFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        // Render report from view
        $report = $this->renderFile(
            __DIR__ . '/../views/asset-migration/report.php',
            [
                'bowerAssets' => $bowerAssets,
                'npmAssets' => $npmAssets,
            ]
        );

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
        $outputDir = Yii::getAlias($this->outputPath);
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
     * Generates .bowerrc configuration file
     */
    protected function generateBowerrc()
    {
        $outputDir = Yii::getAlias($this->outputPath);
        $bowerrcFile = $outputDir . '/.bowerrc';

        $bowerrc = [
            'directory' => '/app/vendor/bower-asset'
        ];

        if (!$this->confirmFileWrite($bowerrcFile)) {
            $this->stdout("Skipped: $bowerrcFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        file_put_contents($bowerrcFile, Json::encode($bowerrc, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->stdout("✓ Generated: $bowerrcFile\n", \yii\helpers\Console::FG_GREEN);
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
     * Generates .yarnrc configuration file for yarn --modules-folder option
     */
    protected function generateYarnrc()
    {
        $outputDir = Yii::getAlias($this->outputPath);
        $yarnrcFile = $outputDir . '/.yarnrc';

        $yarnrc = "# file generated with AI assistance: Claude Code - " . date('Y-m-d') . "\n";
        $yarnrc .= "--modules-folder /app/node_modules\n";

        if (!$this->confirmFileWrite($yarnrcFile)) {
            $this->stdout("Skipped: $yarnrcFile\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        file_put_contents($yarnrcFile, $yarnrc);

        $this->stdout("✓ Generated: $yarnrcFile\n", \yii\helpers\Console::FG_GREEN);
    }

    /**
     * Generates empty yarn.lock file
     */
    protected function generateYarnLock()
    {
        $outputDir = Yii::getAlias($this->outputPath);
        $yarnLockFile = $outputDir . '/yarn.lock';

        if (file_exists($yarnLockFile)) {
            $this->stdout("Skipped: $yarnLockFile (already exists)\n", \yii\helpers\Console::FG_YELLOW);
            return;
        }

        $yarnLock = "# THIS IS AN AUTOGENERATED FILE. DO NOT EDIT THIS FILE DIRECTLY.\n";
        $yarnLock .= "# yarn lockfile v1\n\n";

        file_put_contents($yarnLockFile, $yarnLock);

        $this->stdout("✓ Generated: $yarnLockFile\n", \yii\helpers\Console::FG_GREEN);
    }

    /**
     * Generates composer.json with replace directives in assets-replaced directory
     *
     * @param array $bowerAssets Bower assets map
     * @param array $npmAssets NPM assets map
     */
    protected function generateComposerAssets($bowerAssets, $npmAssets)
    {
        $outputDir = Yii::getAlias($this->outputPath);
        $assetsReplacedDir = $outputDir . '/assets-replaced';

        // Create directory if it doesn't exist
        if (!is_dir($assetsReplacedDir)) {
            mkdir($assetsReplacedDir, 0755, true);
        }

        $composerAssetsFile = $assetsReplacedDir . '/composer.json';

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
