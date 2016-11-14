<?php

use yii\db\Migration;

class m161114_162930_templates2 extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu_item}}', 'submenuTemplate', $this->string()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%menu_item}}', 'submenuTemplate');
    }
}