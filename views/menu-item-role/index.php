<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Menu Item Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-role-index">
    <p>
        <?= Html::a(Yii::t('frontend', 'Menu Item'), ['menu-item/index']) ?>
    </p>
    <p>
        <?= Html::a(Yii::t('frontend', 'Create Menu Item Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'menu_item_id',
            'role_yii',
            'role_kohana',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
