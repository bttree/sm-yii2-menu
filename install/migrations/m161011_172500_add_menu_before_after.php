<?php

use yii\db\Migration;

class m161011_172500_add_menu_before_after extends Migration
{
    public function up()
    {
        $this->addColumn('{{%menu_item}}','before_label', $this->string());
        $this->addColumn('{{%menu_item}}','after_label',  $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%menu_item}}','before_label');
        $this->dropColumn('{{%menu_item}}','after_label');
    }
}