<?php

namespace app\services\scanners;

use lajax\translatemanager\services\Scanner;
use lajax\translatemanager\services\scanners\ScannerDatabase as BaseScannerDatabase;
use Yii;
use yii\helpers\Console;


/**
 * Find pattern in db. Default pattern is t('category','message')
 *
 *
 * Configuration:
 *
 * ```
 *   'translatemanager' => [
 *      'root' => '@project',
 *      'tables' => [
 *          [
 *              'connection' => 'db',
 *              'table' => '{{%hrzg_widget_template}}',
 *              'columns' => ['twig_template']
 *          ]
 *      ],
 *      'scanners' => [
 *          lajax\translatemanager\services\scanners\ScannerPhpFunction::class,
 *          lajax\translatemanager\services\scanners\ScannerPhpArray::class,
 *          lajax\translatemanager\services\scanners\ScannerJavaScriptFunction::class,
 *          project\services\scanners\ScannerDatabase::class
 *      ],
 *   ],
 * ```
 *
 * @package project\services\scanners
 * @author Elias Luhr <e.luhr@herzogkommunikation.de>
 *
 * @property string pattern
 * @property integer categoryGroup
 * @property string messageGroup
 * @property Scanner _scanner
 * @property array _tables
 */
class ScannerDatabase extends BaseScannerDatabase
{
    /**
     * @var Scanner object containing the detected language elements
     */
    private $_scanner;

    /**
     * @var array array containing the table ids to process.
     */
    private $_tables;

    /**
     * @var string Pattern for finding translate function
     */
    public $pattern = '/[ \W]t\s*\(\s*(["\'])([\w\s-_]*?[^\\\\])\1\s*,\s*?(["\'])(.*?[^\\\\])\3/im';

    /**
     * @var integer Regex group for category in pattern
     */
    public $categoryGroup = 2;

    /**
     * @var integer Regex group for message in pattern
     */
    public $messageGroup = 4;


    /**
     * @param Scanner $scanner
     */
    public function __construct(Scanner $scanner)
    {
        $this->_scanner = $scanner;
        $this->_tables = Yii::$app->getModule('translatemanager')->tables;

        if (!empty($this->_tables) && \is_array($this->_tables)) {
            foreach ($this->_tables as $tables) {
                if (empty($tables['connection'])) {
                    throw new InvalidConfigException('Incomplete database  configuration: connection ');
                }
                if (empty($tables['table'])) {
                    throw new InvalidConfigException('Incomplete database  configuration: table ');
                }

                if (empty($tables['columns'])) {
                    throw new InvalidConfigException('Incomplete database  configuration: columns ');
                }
            }
        }
    }

    /**
     * Scanning database tables defined in configuration file. Searching for language elements yet to be translated.
     */
    public function run()
    {
        $this->_scanner->stdout('Detect DatabaseTable - BEGIN', Console::FG_GREY);
        if (\is_array($this->_tables)) {
            foreach ($this->_tables as $tables) {
                $this->_scanningTable($tables);
            }
        }

        $this->_scanner->stdout('Detect DatabaseTable - END', Console::FG_GREY);
    }

    /**
     * Scanning database table
     *
     * @param array $tables
     * @throws \yii\db\Exception
     */
    private function _scanningTable($tables)
    {
        $this->_scanner->stdout('Extracting messages from ' . $tables['table'] . '.' . implode(',', $tables['columns']), Console::FG_GREEN);
        $query = new \yii\db\Query();
        $data = $query->select($tables['columns'])
            ->from($tables['table'])
            ->createCommand(Yii::$app->{$tables['connection']})
            ->queryAll();

        foreach ($data as $columns) {

            $columns = array_map('trim', $columns);

            foreach ($columns as $column) {

                $parsing = preg_match_all($this->pattern, $column, $matches);

                if ($parsing === false) {
                    $this->_scanner->stdout('An error occurred while checking for pattern' . PHP_EOL, Console::BOLD, Console::FG_RED);
                } else {
                    if (isset($matches[$this->categoryGroup], $matches[$this->messageGroup])) {
                        $categories = $matches[$this->categoryGroup];
                        $messages = $matches[$this->messageGroup];

                        for ($i = 0; $i < \count($categories); $i++) {
                            $this->_scanner->addLanguageItem($categories[$i], $messages[$i]);
                        }
                    }
                }

            }
        }
    }
}
