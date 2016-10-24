<?php

namespace koma136\smymenu\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_item_role".
 *
 * @property integer  $id
 * @property integer  $menu_item_id
 * @property integer  $role_yii
 * @property integer  $role_kohana
 *
 * @property MenuItem $menuItem
 */
class MenuItemRole extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_item_id'], 'required'],
            [['menu_item_id', 'role_kohana'], 'integer'],
            [['role_yii'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('frontend', 'ID'),
            'menu_item_id' => Yii::t('frontend', 'Menu Item ID'),
            'role_yii'     => Yii::t('frontend', 'Role Yii'),
            'role_kohana'  => Yii::t('frontend', 'Role Kohana'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'menu_item_id']);
    }

    /**
     * @param array $roles
     *
     * @return array
     */
    public static function getYiiRoles($roles = []) {
        $result = [];
        if(empty($roles)) {
            $roles = Yii::$app->authManager->getRoles();
        }
        foreach ($roles as $role) {
            $result[$role->name] = Yii::t('frontend', ucfirst($role->name));
        }

        return $result;
    }
}