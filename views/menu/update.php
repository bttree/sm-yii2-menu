<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model bttree\smymenu\models\Menu */

$this->title = Yii::t('smy.menu', 'Update menu: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('smy.menu', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('smy.menu', 'Update');
?>
<div class="menu-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
