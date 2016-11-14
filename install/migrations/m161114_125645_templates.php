<?php

use yii\db\Migration;

class m161114_125645_templates extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu}}', 'submenuTemplate', $this->string()->null());
        $this->addColumn('{{%menu_item}}',
                         'template',
                         $this->string()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%menu_item}}', 'template');
        $this->dropColumn('{{%menu}}', 'submenuTemplate');
    }
}