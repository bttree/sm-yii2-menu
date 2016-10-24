<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('frontend', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <p>
        <?= Html::a(Yii::t('frontend', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('frontend', 'Menu Items'), ['menu-item/index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 'id',
                                 'name',
                                 'code',
                                 'status',

                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>
</div>
