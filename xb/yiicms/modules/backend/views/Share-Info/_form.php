<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use app\models\ShareInfo;
/* @var $this yii\web\View */
/* @var $model app\models\ShareInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="share-info-form  panel panel-default">

    <?php $form = ActiveForm::begin(
        [
            'options' => ['enctype'=>'multipart/form-data'],
            'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>"],
        ]
    ); ?>

            <?= $form->field($model, 'event')->DropDownList(ShareInfo::$eventList) ?>

            <?= $form->field($model, 'platform')->DropDownList(ShareInfo::$platForm) ?>

    <?= $form->field($model, 'imageFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->img_url)?'':\yii::$app->params['imgcdn'].$model->img_url,
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('input[name=\"ShareInfo[imageFile]\"]').val('');}",
                "filebatchselected" => "function(event, files) { $('input[name=\"ShareInfo[imageFile]\"]').val(files[0].name);}",
            ],

        ]
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'target_url')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>'margin-left: 1%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
