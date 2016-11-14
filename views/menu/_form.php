<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bttree\smymenu\models\Menu;

/* @var $this yii\web\View */
/* @var $model bttree\smymenu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel panel-white">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'submenuTemplate')->textInput(['maxlength' => true]) ?>
        <p class="hint"><?= Yii::t('smy.menu', 'Hint:') ?> <?= htmlspecialchars('"\n<ul>\n{items}\n</ul>\n"') ?></p>

        <?= $form->field($model, 'status')->dropDownList(Menu::getStatusArray()) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('smy.menu', 'Create') : Yii::t('smy.menu', 'Update'),
                                   ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>