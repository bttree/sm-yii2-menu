<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\MenuItemRole */

$this->title = Yii::t('frontend', 'Update {modelClass}: ', [
    'modelClass' => 'Menu Item Role',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Menu Item Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="menu-item-role-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
