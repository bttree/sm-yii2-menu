<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\Menu */

$this->title = Yii::t('frontend', 'Create Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
