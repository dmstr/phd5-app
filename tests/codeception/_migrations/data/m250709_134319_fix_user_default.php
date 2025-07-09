<?php

use yii\db\Migration;

class m250709_134319_fix_user_default extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%user}}', ['uuid' => '401eb1e5-0fe9-43c3-9104-1a0fcb8fd1af'], ['id' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250709_134319_fix_user_default cannot be reverted.\n";

        return false;
    }
}
