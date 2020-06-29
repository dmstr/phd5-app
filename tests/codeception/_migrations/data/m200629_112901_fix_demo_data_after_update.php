<?php

use yii\db\Expression;
use yii\db\Migration;

class m200629_112901_fix_demo_data_after_update extends Migration
{
    public function safeUp()
    {

        $this->update('{{%dmstr_page}}', ['route' => '/backend/rbac/assignments'], ['route' => '/backend/default/show-auth']);
        $this->update('{{%dmstr_page}}', ['route' => '/backend/config/view'], ['route' => '/backend/default/view-config']);

        $this->update('{{%settings}}', ['value' => new Expression('REPLACE(value, "/backend/default/view-config","/backend/config/view")')], ['section' => 'pages', 'key' => 'availableGlobalRoutes']);
        $this->update('{{%settings}}', ['value' => new Expression('REPLACE(value, "/backend/default/show-auth","/backend/rbac/assignments")')], ['section' => 'pages', 'key' => 'availableGlobalRoutes']);
    }

    public function safeDown()
    {
        echo static::class . ' cannot be reverted.' . PHP_EOL;
        return false;
    }
}
