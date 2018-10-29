<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stype')->textInput() ?>

    <?= $form->field($model, 'id_status')->textInput() ?>

    <?= $form->field($model, 'id_card_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_bg_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_usr_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'real_card_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hospital_id')->textInput() ?>

    <?= $form->field($model, 'department_id')->textInput() ?>

    <?= $form->field($model, 'jobtitle_id')->textInput() ?>

    <?= $form->field($model, 'reg_cert_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_title_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
