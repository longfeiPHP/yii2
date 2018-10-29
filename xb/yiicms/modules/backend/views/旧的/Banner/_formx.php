<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker; 
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(
        [
         'options' => ['enctype'=>'multipart/form-data'],
         'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>"]
        ]
    ); ?>
    <?= $form->field($model, 'imageFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->img)?'':[\yii\helpers\Url::to($model->img)],
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#banner-img').val('');}",
            ],
        ]
    ) ?>
    <?= $form->field($model, 'sid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img',['options'=>['style'=>'display:none']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'h5_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jump_type')->textInput() ?>

    <?= $form->field($model, 'banner_type')->textInput() ?>

    <?= $form->field($model, 'banner_push')->textInput() ?>

    <?= $form->field($model, 'banner_sort')->textInput() ?>

    <?= $form->field($model, 'show_start_time')->textInput() ?>

    <?= $form->field($model, 'show_end_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
