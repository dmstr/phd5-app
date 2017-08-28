<?php

use yii\db\Migration;

class m160313_153425_session_move extends Migration
{
    public function up()
    {
        $this->renameTable('{{%session}}', '__tmp_session');
    }

    public function down()
    {
        echo "m170125_172631_session_move cannot be reverted.\n";

        return false;
    }
}
