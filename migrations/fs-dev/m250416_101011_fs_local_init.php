<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2025 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class m250416_101011_fs_local_init extends \dmstr\db\mysql\FileMigration
{

    public function up()
    {


        $fsLocalDir = getenv('FILEMANAGER_FS_LOCAL_ROOT') ? rtrim(getenv('FILEMANAGER_FS_LOCAL_ROOT'), '/') . '/fs-local' : '/mnt/storage/fs-local';
        $rootFsPath = dirname($fsLocalDir);
        // init the filesystem itself from tar.gz
        if (!is_dir($rootFsPath) || !is_writable($rootFsPath)) {
            Yii::error('root fs dir must exist and must be writeable');
            return false;
        }

        if (is_dir($fsLocalDir)) {
            echo "$fsLocalDir exists"  . PHP_EOL;
        }
        $phar = new PharData(__DIR__ . '/fs-local-init.tar');
        $phar->extractTo($rootFsPath, null, true);
        echo "fs-local tree initialized." . PHP_EOL;

        return parent::up();
    }

}