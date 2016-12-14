<?php

namespace bttree\smymenu\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer    $id
 * @property string     $name
 * @property string     $code
 * @property string     $submenuTemplate
 * @property integer    $status
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'status'], 'required'],
            [['status'], 'integer'],
            [['name', 'code', 'submenuTemplate'], 'string', 'max' => 255],
            ['code', 'unique', 'message' => 'This code has already been taken.'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('smy.menu', 'ID'),
            'name'            => Yii::t('smy.menu', 'Name'),
            'code'            => Yii::t('smy.menu', 'Code'),
            'status'          => Yii::t('smy.menu', 'Status'),
            'template'        => Yii::t('smy.menu', 'Template'),
            'submenuTemplate' => Yii::t('smy.menu', 'Submenu template'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (empty($this->status)) {
            $this->status = self::STATUS_ACTIVE;
        }

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public static function getAllArrayForSelect()
    {
        return ArrayHelper::map(self::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('smy.menu', 'Active'),
            self::STATUS_DISABLED => Yii::t('smy.menu', 'Disabled'),
        ];
    }

    /**
     * Finds menu by code
     *
     * @param string $code
     * @return static|null
     */
    public static function findByCode($code)
    {
        return self::findOne(['code' => $code, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param  string  $code
     * @param  integer $parent_id
     * @param  boolean $all
     *
     * @return array
     */
    public static function getMenu($code, $parent_id = null, $all = true) {

        $menu = self::findByCode($code);

        if (!isset($menu)) {
            Yii::warning('Menu ' . $code . ' not found!');
            return [];
        }
        $menu_items = self::getMenuItemsRecursive($menu, $parent_id, $all);
        $menu_items = self::setActiveProperty($menu_items);
        $menu_items = self::removeHiddenItems($menu_items);

        if (empty($menu_items)) {
            Yii::warning('Empty menu by code: ' . $code);
        }


        $result = [
            'items' => $menu_items,
        ];

        $module = Yii::$app->getModule('smymenu')->menuItemTemplate;
        if (!empty($menu->submenuTemplate)) {
            $result['submenuTemplate'] = $menu->submenuTemplate;
        } elseif(!empty($module->submenuTemplate)) {
            $result['submenuTemplate'] = $module->submenuTemplate;
        }

        return $result;
    }
    /**
     * @param  \bttree\smymenu\models\Menu  $menu
     * @param  integer $parent_id
     * @param  boolean $all
     *
     * @return array
     */
    public static function getMenuItemsRecursive($menu, $parent_id = null, $all = true)
    {
        $menu_items_request = $menu->getMenuItems()->joinWith('menu')->joinWith('roles');

        $menu_items_request->andWhere([
            'parent_id' => $parent_id,
        ]);

        if (!Yii::$app->user->isGuest) {
            $menu_items_request->andFilterWhere([
                'or',
                ['IS', 'role_yii', (new Expression('NULL'))],
                [
                    'role_yii' => ArrayHelper::getColumn(
                        Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->getId()),
                        'name')
                ]
            ]);
        } else {
            $menu_items_request->andWhere([
                ['IS', 'role_yii', (new Expression('NULL'))],
            ]);
        }

        $menu_items_request->andWhere([
            '!=', MenuItem::tableName() .'.status', MenuItem::STATUS_DISABLED
        ]);

        $menu_items_request->groupBy('menu_item.id')->orderBy('menu_item.sort');

        $menu_items = ArrayHelper::toArray($menu_items_request->all(),
            [
                'bttree\smymenu\models\MenuItem' => [
                    'label' => function ($menu_item) {
                        $menu_item->title = self::evalPhpScript($menu_item->title);

                        return $menu_item->title;
                    },
                    'url'   => function ($menu_item) {
                        return [$menu_item->url];
                    },
                    'items' => function ($menu_item) use ($menu, $all) {
                        if($all) {
                            return self::getMenuItemsRecursive($menu, $menu_item->id, true);
                        } else {
                            return [];
                        }
                    },
                    'status',
                    'template' => function ($menu_item) {
                        $template = $menu_item->template;
                        if(empty($template)) {
                            $template   = Yii::$app->getModule('smymenu')->menuItemTemplate;
                        }

                        $menu_item->before_label = self::evalPhpScript($menu_item->before_label);
                        $menu_item->after_label  = self::evalPhpScript($menu_item->after_label);

                        $template = str_replace("{before_label}", $menu_item->before_label, $template);
                        $template = str_replace("{after_label}",   $menu_item->after_label, $template);

                        return $template;
                    },
                    'submenuTemplate' => function ($menu_item) {
                        if(!empty($menu_item->submenuTemplate)) {
                            return $menu_item->submenuTemplate;
                        }
                        return Yii::$app->getModule('smymenu')->menuItemSubmenuTemplate;
                    },
                    'options' => function ($menu_item) {
                        if(!empty($menu_item->options)) {
                            return json_decode($menu_item->options);
                        } else {
                            return [];
                        }
                    },
                ],
            ]);

        return $menu_items;
    }

    /**
     * @param string $string
     * @param string $match
     * @return mixed
     */
    protected function evalPhpScript($string, $match = "/php:(.*)/i") {
        $resultString = $string;

        try {
            preg_match($match, $string, $result);
            if(isset($result[1])) {
                $resultString = eval("return {$result[1]};");
            }
        } catch (\Exception $e) {
            $resultString = $string;
        }

        return $resultString;
    }

    /**
     * @param array  $menu_items
     * @param string $class_name
     * @return array
     */
    public static function setActiveProperty($menu_items, $class_name = 'active')
    {
        $controller = Yii::$app->controller->id;
        $action     = Yii::$app->controller->action->id;
        $module     = Yii::$app->controller->module->id;

        $result     = [];
        foreach ($menu_items as $item) {
            $item['items'] = self::setActiveProperty($item['items'], $class_name);

            foreach($item['items'] as $subitem)
            {
                if(!isset($subitem['options'])) $subitem['options']=[];
                if(isset($subitem['options']['class']))
                {
                 if(preg_match('/\b'.$class_name.'\b/i',$subitem['options']['class'])){
                     if(!isset($item['options']['class'])) $item['options']['class']="";
                     $item['options']['class'] = $item['options']['class'] . " " . $class_name;
                     break;
                    }

                }
            }

            if(!isset($item['options']['class']) || !preg_match('/\b'.$class_name.'\b/i',$item['options']['class']))
            {

                if (Yii::$app->request->baseUrl ."/". Yii::$app->request->getPathInfo() == Yii::$app->urlManager->createUrl($item['url']))
                {
                    if(!isset($item['options'])) $item['options']=[];
                    if(!isset($item['options']['class'])) $item['options']['class']="";

                    $item['options']['class'] = $item['options']['class'] . " " . $class_name;
                }
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * @param  array $menu_items
     * @return array
     */
    public static function removeHiddenItems($menu_items) {
        $result = [];
        foreach ($menu_items as $item) {
            $item['items']      = self::removeHiddenItems($item['items']) ;
            if($item['status'] == MenuItem::STATUS_ACTIVE) {
                $result[] = $item;
            }
        }
        return $result;
    }
}