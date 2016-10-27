<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\MenuItemRole */

$this->title = Yii::t('smy.menu', 'Create Menu Item Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('smy.menu', 'Menu Item Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-role-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
