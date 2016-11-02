<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bttree\smymenu\models\MenuItem;
use bttree\smymenu\models\KohanaRole;

/* @var $this yii\web\View */
/* @var $model bttree\smymenu\models\MenuItemRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-white">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'menu_item_id')->dropDownList(MenuItem::getAllArrayForSelect(), ['prompt'=>'---']) ?>

        <?= $form->field($model, 'role_yii')->dropDownList(\bttree\smymenu\models\MenuItemRole::getYiiRoles(), ['prompt'=>'---']) ?>

        <?= $form->field($model, 'role_kohana')->dropDownList(KohanaRole::getAllArrayForSelect(), ['prompt'=>'---']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('smy.menu', 'Add') : Yii::t('smy.menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
