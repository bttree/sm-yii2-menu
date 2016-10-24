<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\MenuItem */

$this->title                   = Yii::t('frontend', 'Create Menu Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Menu Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">
    <?= $this->render('_form',
                      [
                          'model' => $model,
                      ]) ?>

</div>
