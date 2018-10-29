<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use app\models\PushSession;
/* @var $this yii\web\View */
/* @var $model app\models\PushSession */
/* @var $form yii\widgets\ActiveForm,['style'=>'display:none;'] */
?>

<div class="push-session-form panel panel-default">

    <?php $form = ActiveForm::begin(
        [
            'options' => ['enctype'=>'multipart/form-data'],
            'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>"],
        ]
    ); ?>

    <?php 
        if ($model->isNewRecord) {
            echo $form->field($model, 'type')->textInput(['maxlength' => true]);
        }  
    ?>


    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->avatar)?'':\yii::$app->params['imgcdn'].$model->avatar,
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#pushsession-avatar').val('');}",
                
            ],
        ]
    ) ?>

    <?= $form->field($model, 'verified')->DropDownList(PushSession::$VerifyArr) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>'margin-left:1%']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
