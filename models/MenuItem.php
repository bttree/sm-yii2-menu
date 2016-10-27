<?php

namespace koma136\smymenu\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "menu_item".
 *
 * @property integer      $id
 * @property string       $title
 * @property string       $url
 * @property string       $options
 * @property string       $before_label
 * @property string       $after_label
 *
 * @property MenuItemRole[] $roles
 */
class MenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'menu_id'], 'required'],
            [['sort'], 'integer'],
            [['title', 'url', 'options', 'before_label', 'after_label'], 'string', 'max' => 255],
            [
                ['id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => MenuItemRole::className(),
                'targetAttribute' => ['id' => 'menu_item_id']
            ],
        ];
    }
    public function behaviors()
    {
        return [
            'sort' => [
                'class' => 'common\behaviors\Sort',
                'attributeName' => 'sort'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => Yii::t('smy.menu', 'ID'),
            'title'   => Yii::t('smy.menu', 'Title'),
            'url'     => Yii::t('smy.menu', 'Url'),
            'options' => Yii::t('smy.menu', 'Options'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(MenuItemRole::className(), ['menu_item_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getAllArrayForSelect()
    {
        return ArrayHelper::map(self::find()->orderBy('id')->asArray()->all(), 'id', 'title');
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        //todo сделать более гибко!
        if (strpos($this->before_label, 'fa-') !== false) {
            $this->before_label = '<span class="menu-icon"><i  aria-hidden="true" class="fa '. $this->before_label .'"></i></span>';
        }

        return parent::beforeSave($insert);
    }
}