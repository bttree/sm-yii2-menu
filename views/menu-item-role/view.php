<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bttree\smymenu\models\MenuItemRole */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('smy.menu', 'Menu Item Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-role-view">
    <p>
        <?= Html::a(Yii::t('smy.menu', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('smy.menu', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('smy.menu', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'menu_item_id',
            'role_yii',
            'role_kohana',
        ],
    ]) ?>

</div>
