<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PushMessage;
/* @var $this yii\web\View */
/* @var $model app\models\PushMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="push-message-form pbanner-form panel panel-default " style="padding-top: 15px;">

    <?php $form = ActiveForm::begin(
        [
             'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-1'>{label}</span><span class='col-lg-7'>{input}</span><span class='col-lg-2'>{error}</span></div></div>"],
        ]
    ); ?>

        <?= $form->field($model, 'type')->DropDownList(PushMessage::getAllAccount()) ?>
        <?= $form->field($model, 'notity_content')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'notity_title')->textInput(['maxlength' => true]) ?>
        

        <?= $form->field($model, 'im_content')->textarea(['maxlength' => true,'style'=>" min-height:250px;overflow:auto;"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>'margin-left: 1%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
