<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\backend\models\UsersInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => ['template'=>"<div class='col-lg-4'><div class='row'><span class='col-lg-3'>{label}</span><span class='col-lg-9'>{input}</span></div></div>"],
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <?php // echo $form->field($model, 'sid') ?>

    <?= $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'realname') ?>

    <?php  echo $form->field($model, 'stype')->dropDownList([''=>'所有','1'=>'中医','2'=>'西医']); ?>

    <?php  echo $form->field($model, 'id_status')->dropDownList([''=>'所有','1'=>'已认证','0'=>'未认证','2'=>'已驳回']); ?>

    <?php // echo $form->field($model, 'id_card_type') ?>

    <?php // echo $form->field($model, 'id_card_no') ?>

    <?php // echo $form->field($model, 'id_card_img') ?>

    <?php // echo $form->field($model, 'id_card_bg_img') ?>

    <?php // echo $form->field($model, 'id_card_usr_img') ?>

    <?php // echo $form->field($model, 'real_card_img') ?>

    <?php // echo $form->field($model, 'hospital_id') ?>

    <?php // echo $form->field($model, 'department_id') ?>

    <?php // echo $form->field($model, 'jobtitle_id') ?>

    <?php // echo $form->field($model, 'reg_cert_img') ?>

    <?php // echo $form->field($model, 'job_title_img') ?>

    <?php // echo $form->field($model, 'priority') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
