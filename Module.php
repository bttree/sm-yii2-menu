<?php

namespace bttree\smymenu;

use Yii;

/**
 * menu module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'bttree\smymenu\controllers';

    public $menuItemTemplate = '{before_label}<a href="{url}" >{label}</a>{after_label}';
    public $submenuTemplate;

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
                'basePath'       => '@bttree/smymenu/messages'
            ];
        }

        //todo
//        'gridview' =>  [
//        'class' => '\kartik\grid\Module'
//        ]
    }
}