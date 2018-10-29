<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker; 
/* @var $this yii\web\View */
/* @var $model app\models\ChannelSubject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form panel panel-default channel-subject-form">

    <?php $form = ActiveForm::begin([

         'fieldConfig' => ['template'=>"<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>"],
    ]); ?>

    <?= $form->field($model, 'channel_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active_title')->textInput(['maxlength' => true]) ?>

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
            'options' => ['placeholder' => '选择展示开始时间','value'=>$model->show_end_time==0 ? '' : date('Y-m-d h:i:s',$model->show_end_time),], 
            'pluginOptions' => [ 
                'autoclose' => true, 
                'format' => 'yyyy-mm-dd hh:ii:ss', 
                'todayHighlight' => true, 
            ] 
        ]);  
    ?>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
