<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Commentstatus;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(Commentstatus::getAllStatus(),
    		['prompt'=>'请选择状态']
    		) ?>

    <?php //echo $form->field($model, 'create_time')->textInput() ?>

    <?php //echo $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'post_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : '修改', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
