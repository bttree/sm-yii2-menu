<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use koma136\smymenu\models\MenuItem;
use koma136\smymenu\models\KohanaRole;

/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\MenuItemRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-white">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'menu_item_id')->dropDownList(MenuItem::getAllArrayForSelect(), ['prompt'=>'---']) ?>

        <?= $form->field($model, 'role_yii')->dropDownList(\koma136\smymenu\models\MenuItemRole::getYiiRoles(), ['prompt'=>'---']) ?>

        <?= $form->field($model, 'role_kohana')->dropDownList(KohanaRole::getAllArrayForSelect(), ['prompt'=>'---']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('smy.menu', 'Add') : Yii::t('smy.menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
