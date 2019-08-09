<?php

use yii\db\Migration;

class m160313_153427_session_refill extends Migration
{
    public function up()
    {
        $this->execute(
            <<<SQL
INSERT INTO {{%session}} (id, expire, data)
SELECT id, expire, data FROM __tmp_session
SQL
        );
        $this->dropTable('__tmp_session');
    }

    public function down()
    {
        echo "m160313_153427_session_refill cannot be reverted.\n";

        return false;
    }
}
