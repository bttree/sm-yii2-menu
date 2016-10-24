<?php

namespace koma136\smymenu;

use Yii;
/**
 * menu module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'koma136\smymenu\controllers';

    public $userClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::setAlias('@smy', __DIR__);
        // custom initialization code goes here
    }
}

