<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker; 
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form panel panel-default">

    <?php $form = ActiveForm::begin(
        [
         'options' => ['enctype'=>'multipart/form-data'],
         'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>"]
        ]
    ); ?>
    
    

    <?php //= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
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
    <?= $form->field($model, 'img',['options'=>['style'=>'display:none']])->hiddenInput(['id'=>'banner-img'])?>

    <?= $form->field($model, 'jump_type')->dropDownList(['3'=>'动态变化','1'=>'H5链接','2'=>'直播间','0'=>'医生简介'],['prompt'=>'选择跳转方式']) ?>
    <?= $form->field($model, 'sid',['options'=>['style'=>'/*display:none*/']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'h5_url',['options'=>['style'=>'/*display:none*/']])->textInput(['maxlength' => true,'placeholder'=>'http://开头']) ?>

    <?php // $form->field($model, 'banner_type')->textInput() ?>

    <?= $form->field($model, 'banner_push',['options'=>['style'=>'/*display:none*/']])->dropDownList(['1'=>'不显示','0'=>'显示'],['prompt'=>'选择是否弹出通知']) ?>


    <?= $form->field($model, 'show_start_time')->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择展示开始时间'], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                // 'format' => 'y-m-d H:i:s', 
                'todayHighlight' => true, 
            ] 
        ]);  
    ?>

    <?= $form->field($model, 'show_end_time')->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择展示结束时间'], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                // 'format' => 'y-m-d H:i:s', 
                'todayHighlight' => true, 
            ] 
        ]); 
    ?>

    <?= $form->field($model, 'live_start_time',['options'=>['style'=>'display:none']])->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择科普开始时间'], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                // 'format' => 'y-m-d H:i:s', 
                'todayHighlight' => true, 
            ] 
        ]); 
    ?>

    <?= $form->field($model, 'live_end_time',['options'=>['style'=>'display:none']])->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择科普结束时间'], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                // 'format' => 'y-m-d H:i:s', 
                'todayHighlight' => true, 
            ] 
        ]); 

    ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-primary ' : 'btn btn-success','style'=>'margin-left: 15px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
