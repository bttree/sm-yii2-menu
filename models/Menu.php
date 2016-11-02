<?php

namespace bttree\smymenu\models;

use Yii;
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
}