<?php

use yii\db\Migration;

class m161006_093955_menu extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu_item}}',
                           [
                               'id'      => $this->primaryKey(),
                               'title'   => $this->string()->notNull(),
                               'url'     => $this->string()->notNull(),
                               'options' => $this->string()->null(),
                           ],
                           $tableOptions);

        $this->createTable('{{%menu_item_role}}',
                           [
                               'id'           => $this->primaryKey(),
                               'menu_item_id' => $this->integer()->notNull(),
                               'role_yii'     => $this->string()->null(),
                               'role_kohana'  => $this->integer()->null(),
                           ],
                           $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_item}}');
        $this->dropTable('{{%menu_item_role}}');
    }
}