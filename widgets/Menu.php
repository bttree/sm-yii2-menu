<?php


namespace bttree\smymenu\widgets;

use Yii;
use yii\widgets\Menu as BaseMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class Menu extends BaseMenu
{

    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            if(preg_match("/(https|http):\/\/(.*)/i",$item['url'][0])){
                return strtr($template, [
                    '{url}' => Html::encode($item['url'][0]),
                    '{label}' => $item['label'],
                ]);
            }else{
                return strtr($template, [
                    '{url}' => Html::encode(Url::to($item['url'],true)),
                    '{label}' => $item['label'],
                ]);
            }

        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }

}
