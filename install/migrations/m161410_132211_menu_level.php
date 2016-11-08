<?php

use yii\db\Migration;

class m161410_132211_menu_level extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu_item}}', 'parent_id', $this->integer()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%menu_item}}', 'parent_id');
    }
}