<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use bttree\smymenu\models\Menu;
use bttree\smymenu\models\MenuItem;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel  \yii\base\Model */

$this->title                   = Yii::t('smy.menu', 'Menu Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-index">
    <p>
        <?= Html::a(Yii::t('smy.menu', 'Create Menu Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'id'           => 'menu-item-grid',
            'columns'      => [
                'id',
                [
                    'attribute'       => 'sort',
                    'class'           => 'kartik\grid\EditableColumn',
                    'editableOptions' => function ($model, $key, $index) {
                        return [
                            'asPopover' => false,
                            'size'      => 'sm',
                        ];
                    }
                ],
                'title',
                'url',
                [
                    'attribute' => 'menu_id',
                    'value'     => function ($model) {
                        $menu = $model->menu;
                        return isset($menu) ? 'ID:' . $menu->id . ' ' . $menu->name : '---';
                    },
                    'filter'    => Menu::getAllArrayForSelect()
                ],
                [
                    'attribute' => 'parent_id',
                    'value'     => function ($model) {
                        $parent = $model->parent;
                        return isset($parent) ? 'ID:' . $parent->id . ' ' . $parent->title : '---';
                    },
                    'filter'    => MenuItem::getAllArrayForSelect()
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>
    <?php Pjax::end(); ?>
</div>
