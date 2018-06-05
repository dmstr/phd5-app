<?php

use yii\db\Migration;

/**
 * Class m000508_053522_fix_migration_table
 */
class m000508_053522_fix_migration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->schema->getTableSchema('{{%migration}}');
        if (isset($table->columns['alias'])) {
            // Column exists
            $this->alterColumn('{{%migration}}', 'alias', 'varchar(180) DEFAULT NULL');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m000508_053522_fix_migration_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m000508_053522_fix_migration_table cannot be reverted.\n";

        return false;
    }
    */
}
