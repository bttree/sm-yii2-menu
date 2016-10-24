<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\Menu */

$this->title = Yii::t('frontend', 'Update {modelClass}: ', [
    'modelClass' => 'Menu',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="menu-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
