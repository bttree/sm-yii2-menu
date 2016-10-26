<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use koma136\smymenu\models\Menu;
use koma136\smymenu\models\MenuItemRole;

/* @var $this yii\web\View */
/* @var $model koma136\smymenu\models\MenuItem */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="panel panel-white">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'menu_id')->dropDownList(Menu::getAllArrayForSelect()) ?>

            <?= $form->field($model, 'before_label')->textInput() ?>
            <?= $form->field($model, 'after_label')->textInput() ?>
            <?= $form->field($model, 'sort')->textInput() ?>

            <div class="form-group">
                <label class="control-label"><?= Yii::t('frontend', 'Permissions') ?></label>
                <?= Select2::widget([
                                        'name'    => 'Roles[]',
                                        'data'    => MenuItemRole::getYiiRoles(),
                                        'value'   => ArrayHelper::map($model->roles, 'id', 'role_yii'),
                                        'options' => [
                                            'placeholder' => Yii::t('frontend', 'Select roles...'),
                                            'multiple'    => true
                                        ],
                                    ]);
                ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Add') : Yii::t('frontend', 'Update'),
                                       ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php
$this->registerJs("
$('#menuitem-before_label').iconpicker({placement: 'bottomLeft'});
",
                  View::POS_END,
                  'my-options');
?>