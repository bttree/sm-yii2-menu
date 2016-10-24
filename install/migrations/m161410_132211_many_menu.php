<?php

use yii\db\Migration;

class m161410_132211_many_menu extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->truncateTable('{{%menu_item}}');

        $this->addColumn('{{%menu_item}}', 'menu_id', $this->integer()->notNull());

        $this->createTable('{{%menu}}',
                           [
                               'id'     => $this->primaryKey(),
                               'name'   => $this->string()->notNull(),
                               'code'   => $this->string()->notNull()->unique(),
                               'status' => $this->integer()->notNull(),
                           ],
                           $tableOptions);

        $this->addForeignKey('{{%fk_menu_menu_item}}', '{{%menu_item}}', 'menu_id', '{{%menu}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_menu_menu_item}}', '{{%menu_item}}');
        $this->dropTable('{{%menu}}');
        $this->dropColumn('{{%menu_item}}', 'menu_id');
    }
}