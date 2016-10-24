<?php

use yii\db\Migration;

class m161017_140304_update_menu_item_sort extends Migration
{
    public function up()
    {
        $this->addColumn('{{%menu_item}}', 'sort', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%menu_item}}', 'sort');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
