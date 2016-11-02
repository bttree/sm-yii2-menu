<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model bttree\smymenu\models\Menu */

$this->title = Yii::t('smy.menu', 'Create Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('smy.menu', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
