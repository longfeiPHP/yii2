<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\backend\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-search panel panel-default">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'fieldConfig' => ['template'=>"<div class='col-lg-4'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-7'>{input}</span><span class='col-lg-2'>{error}</span></div></div>"],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'status')->dropDownList([''=>'所有','1'=>'已发布','0'=>'未发布']) ?>

    <?php // $form->field($model, 'image') ?>

    <?php // $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'admin_user_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('查找', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
