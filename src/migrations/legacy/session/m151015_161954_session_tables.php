<?php

class m151015_161954_session_tables extends \yii\db\Migration
{
    public function up()
    {
        $this->execute(
            <<<'SQL'
CREATE TABLE {{%session}}
(
    id CHAR(40) NOT NULL PRIMARY KEY,
    expire INTEGER,
    data BLOB
)
SQL
        );
    }
}
