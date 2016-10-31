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
        
        if (!isset(Yii::$app->i18n->translations['smy.menu'])) {
            Yii::$app->i18n->translations['smy.menu'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'ru',
                'basePath'       => '@koma136/smymenu/messages'
            ];
        }
    }
}