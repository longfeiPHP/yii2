<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\backend\models\BannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-search panel panel-default">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
         'options'=>['class' => ''],
        'fieldConfig' => ['template'=>"<div class='col-lg-8'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-9'>{input}</span></div></div>"]

    ]); ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'banner_type') ?>

    <?php // echo $form->field($model, 'banner_push') ?>

    <?php // echo $form->field($model, 'banner_sort') ?>

    <?php // echo $form->field($model, 'show_start_time') ?>

    <?php // echo $form->field($model, 'show_end_time') ?>

    <?php // echo $form->field($model, 'live_start_time') ?>

    <?php // echo $form->field($model, 'live_end_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
