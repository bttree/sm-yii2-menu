<?php

namespace bttree\smymenu\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class Sort extends Behavior
{
    public $attributeName = 'position';
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'setSort'
        ];
    }

    public function setSort( $event )
    {
        if ($this->owner->getIsNewRecord()) {
            $position = Yii::$app->getDb()->createCommand("select max({$this->attributeName}) from {$this->owner->tableName()}")->queryScalar();
            $this->owner->{$this->attributeName} = (int)$position + 1;
        }
        
    }

}