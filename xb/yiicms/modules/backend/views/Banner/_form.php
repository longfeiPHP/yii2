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
         'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>"],
        
         'action' => $model->isNewRecord ? '/backend/banner/create.html?banner_type='.$banner_type : '/backend/banner/update.html?id='.$model->id,
        ]
    ); ?>
    
    

    <?php //= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'imageFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->img)?'':\yii::$app->params['imgcdn'].$model->img,
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#banner-img').val('');}",
            ],
        ]
    ) ?>
    

    <?= $form->field($model, 'jump_type')->dropDownList(['3'=>'动态变化','1'=>'H5链接','2'=>'直播间','0'=>'主播简介'],['prompt'=>'选择跳转方式']) ?>
    <?= $form->field($model, 'sid',['options'=>['style'=>'display:none']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'h5_url',['options'=>['style'=>'display:none']])->textInput(['maxlength' => true,'placeholder'=>'http://开头']) ?>

    <?php // $form->field($model, 'banner_type')->textInput() ?>

    <?= $form->field($model, 'banner_push',['options'=>['style'=>'display:none']])->dropDownList(['0'=>'否','1'=>'是']) ?>


    <?= $form->field($model, 'show_start_time')->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择展示开始时间','value'=>$model->show_start_time==0 ? '' : date('Y-m-d h:i:s',$model->show_start_time),], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                'format' => 'yyyy-mm-dd hh:ii:ss', 
                'todayHighlight' => true, 
            ] 
        ]);  
    ?>

    <?= $form->field($model, 'show_end_time')->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择展示结束时间','value'=>$model->show_end_time==0 ? '' : date('Y-m-d h:i:s',$model->show_end_time),], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                'format' => 'yyyy-mm-dd hh:ii:ss', 
                'todayHighlight' => true,
            ] 
        ]); 
    ?>

    <?= $form->field($model, 'live_start_time',['options'=>['style'=>'display:none']])->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择科普开始时间','value'=>$model->live_start_time==0 ? '' : date('Y-m-d h:i:s',$model->live_start_time),], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                'format' => 'yyyy-mm-dd hh:ii:ss', 
                'todayHighlight' => true, 
            ] 
        ]); 
    ?>

    <?= $form->field($model, 'live_end_time',['options'=>['style'=>'display:none']])->widget(DateTimePicker::classname(), [ 
            'options' => ['placeholder' => '选择科普结束时间','value'=>$model->live_end_time==0 ? '' : date('Y-m-d h:i:s',$model->live_end_time),], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                'format' => 'yyyy-mm-dd hh:ii:ss', 
                'todayHighlight' => true, 
            ] 
        ]); 

    ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-primary ' : 'btn btn-success','style'=>'margin-left: 15px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    
    $('#banner-jump_type').change(function(){
        /**/
        var sel_val=$('#banner-jump_type').val();
        
        $('.field-banner-sid ,.field-banner-h5_url ,.field-banner-live_start_time ,.field-banner-live_end_time,.field-banner-banner_push').hide();
        // $('#w0').yiiActiveForm('remove', "banner-live_start_time");
        // $('#w0').yiiActiveForm('remove', "banner-live_end_time");
        // $('#w0').yiiActiveForm('remove', "banner-sid");
        // $('#w0').yiiActiveForm('remove', "banner-h5_url");
        // $('#w0').yiiActiveForm('remove', "banner_push");
        $('#w0').yiiActiveForm('resetForm'); 

        if (sel_val==3) {
            $('.field-banner-sid ,.field-banner-h5_url ,.field-banner-live_start_time ,.field-banner-live_end_time,.field-banner-banner_push').show();
            add_rule("live_start_time","科普开始时间必填。");
            add_rule("live_end_time","科普结束时间必填。");
            add_rule("sid","主播Id必填。");
            add_rule("banner_push","必选。");
            add_url_rule("h5_url","跳转链接必填。");
        }else if (sel_val==1) {
            $('.field-banner-h5_url').show();
            add_url_rule("h5_url","跳转链接必填。");
        }else if (sel_val==2) {
            $('.field-banner-sid ,.field-banner-live_start_time ,.field-banner-live_end_time,.field-banner-banner_push').show();
            add_rule("live_start_time","科普开始时间必填。");
            add_rule("live_end_time","科普结束时间必填。");
            add_rule("sid","主播Id必填。");
            add_rule("banner_push","必选。");
        }else if (sel_val==0) {
            $('.field-banner-sid ').show();
            add_rule("sid","主播Id必填。");
        };

    });
    function add_rule (id,msg) {
        //live_start_time
        $('#w0').yiiActiveForm('add', {
                "id": "banner-"+id,
                "name": id,
                "container": ".field-banner-"+id,
                "input": "#banner-"+id,
                "validate": function(attribute, value, messages, deferred, form) {
                    yii.validation.required(value, messages, { "message": msg });
                }
            });
    }
    function add_url_rule (id,msg) {
        //live_start_time
        var strRegex =/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
        $('#w0').yiiActiveForm('add', {
                "id": "banner-"+id,
                "name": id,
                "container": ".field-banner-"+id,
                "input": "#banner-"+id,
                "validate": function(attribute, value, messages, deferred, form) {
                    yii.validation.url(value, messages, { "message": msg,'pattern':strRegex,'defaultScheme':'' });
                }
            });
    }
</script>