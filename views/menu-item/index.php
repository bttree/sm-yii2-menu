<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('smy.menu', 'Menu Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-index">
    <p>
        <?= Html::a(Yii::t('smy.menu', 'Create Menu Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget(
        ['dataProvider' => $dataProvider,
            'id'=>'menu-item-grid',
            'columns' => [
    //            ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'attribute'=>'sort',
                    'class' => 'kartik\grid\EditableColumn',
                    'editableOptions'=> function ($model, $key, $index) {
                        return [
                            'asPopover'=>false,
                            'size'=>'sm',
                                ];
                    }
                ],
            'title',
            'url',
            ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>
    <?php Pjax::end(); ?>
</div>
