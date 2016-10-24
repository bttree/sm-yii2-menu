<?php

use yii\db\Migration;

class m161011_172501_add_menu_before_after_fix extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%menu_item}}','before');
        $this->dropColumn('{{%menu_item}}','after');
    }
}