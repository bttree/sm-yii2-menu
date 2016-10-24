<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\MenuItem */

$this->title                   = Yii::t('frontend',
                                        'Update {modelClass}: ',
                                        [
                                            'modelClass' => 'Menu Item',
                                        ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Menu Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="menu-item-update">
    <?= $this->render('_form',
                      [
                          'model' => $model,
                          'selected_roles' => ArrayHelper::map($model->roles, 'id', 'role_yii'),
                      ]) ?>

</div>
