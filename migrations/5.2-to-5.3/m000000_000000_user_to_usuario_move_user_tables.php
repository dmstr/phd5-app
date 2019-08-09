<?php

use yii\db\Migration;

/**
 * Class m181122_143505_user_module
 */
class m000000_000000_user_to_usuario_move_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%user}}', true)) {
            $this->renameTable('{{%user}}', '{{%__tmp_user}}');
        }
        if ($this->db->getTableSchema('{{%profile}}', true)) {
            $this->renameTable('{{%profile}}', '{{%__tmp_profile}}');
        }
        if ($this->db->getTableSchema('{{%token}}', true)) {
            $this->renameTable('{{%token}}', '{{%__tmp_token}}');
        }
        if ($this->db->getTableSchema('{{%social_account}}', true)) {
            $this->renameTable('{{%social_account}}', '{{%__tmp_social_account}}');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181122_143505_user_module cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181122_143505_user_module cannot be reverted.\n";

        return false;
    }
    */
}
