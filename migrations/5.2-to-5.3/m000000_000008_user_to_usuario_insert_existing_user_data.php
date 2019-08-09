<?php

use yii\db\Migration;

class m000000_000008_user_to_usuario_insert_existing_user_data extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%__tmp_user}}', true)) {
            $query = new \yii\db\Query();
            $data = $query->select('*')->from('{{%__tmp_user}}')->all();
            foreach ($data as $row) {
                $this->insert('{{%user}}', $row);
            }
        }

        if ($this->db->getTableSchema('{{%__tmp_social_account}}', true)) {
            $query = new \yii\db\Query();
            $data = $query->select('*')->from('{{%__tmp_social_account}}')->all();
            foreach ($data as $row) {
                $this->insert('{{%social_account}}', $row);
            }
        }

        if ($this->db->getTableSchema('{{%__tmp_token}}', true)) {
            $query = new \yii\db\Query();
            $data = $query->select('*')->from('{{%__tmp_token}}')->all();
            foreach ($data as $row) {
                $this->insert('{{%token}}', $row);
            }
        }

        if ($this->db->getTableSchema('{{%__tmp_profile}}', true)) {
            $query = new \yii\db\Query();
            $data = $query->select('*')->from('{{%__tmp_profile}}')->all();
            foreach ($data as $row) {
                $this->insert('{{%profile}}', $row);
            }
        }

        try {
            $this->dropTable('{{%__tmp_token}}');
            $this->dropTable('{{%__tmp_social_account}}');
            $this->dropTable('{{%__tmp_profile}}');
            $this->dropTable('{{%__tmp_user}}');
        } catch (Exception $e) {
            Yii::info($e->getMessage(), __METHOD__);
        }
    }
}
