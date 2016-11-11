<?php

use yii\db\Migration;

class m161111_105500_menu_item_status extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%menu_item}}', 'status', $this->integer()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%menu_item}}', 'status');
    }
}