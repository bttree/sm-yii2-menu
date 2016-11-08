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
            [['name', 'code'], 'string', 'max' => 255],
            ['code', 'unique', 'message' => 'This code has already been taken.'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => Yii::t('smy.menu', 'ID'),
            'name'   => Yii::t('smy.menu', 'Name'),
            'code'   => Yii::t('smy.menu', 'Code'),
            'status' => Yii::t('smy.menu', 'Status'),
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
    public static function getMenu($code, $parent_id = null, $all = true)
    {
        $menu_items_request = MenuItem::find()->joinWith('menu')->joinWith('roles')->where(
            [
                'code'     => $code,
            ]
        );

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

        $menu_items_request->groupBy('menu_item.id')->orderBy('menu_item.sort');

        $menu_items = ArrayHelper::toArray($menu_items_request->all(),
                                           [
                                               'bttree\smymenu\models\MenuItem' => [
                                                   'label' => function ($menu_item) {
                                                       return  $menu_item->before_label
                                                               .'<p>'.
                                                               $menu_item->title
                                                               .'</p>'.
                                                               $menu_item->after_label;
                                                   },
                                                   'url'   => function ($menu_item) {
                                                       return [$menu_item->url];
                                                   },
                                                   'items' => function ($menu_item) use ($code, $all) {
                                                       if($all) {
                                                           return self::getMenu($code, $menu_item->id, true);
                                                       } else {
                                                           return [];
                                                       }
                                                   },
                                               ],
                                           ]);

        if(empty($menu_items)) {
            Yii::warning('Empty menu by code: '. $code);
        }
        return $menu_items;
    }

    /**
     * @param  string  $code
     * @param  integer $parent_id
     *
     * @return array
     */
    public static function getMenuTree($code, $parent_id) {
        return self::getMenu($code, $parent_id);
    }
}