<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search panel panel-default">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=>['class' => ''],
        'fieldConfig' => ['template'=>"<div class='col-lg-3'><div class='row'><span class='col-lg-3'>{label}</span><span class='col-lg-9'>{input}</span></div></div>"]
    ]); 
    ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'sid') ?>

    <?= $form->field($model, 'mobile')->dropDownList(["1","2","3"],[]) ?>

    <?= $form->field($model, 'third_type') ?>

    <?php // echo $form->field($model, 'third_account') ?>

    <?php // echo $form->field($model, 'unionid') ?>

    <?php // echo $form->field($model, 'mpopenid') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'realname') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'star_level') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'blood_type') ?>

    <?php // echo $form->field($model, 'interest') ?>

    <?php // echo $form->field($model, 'job') ?>

    <?php // echo $form->field($model, 'id_card_type') ?>

    <?php // echo $form->field($model, 'id_card_no') ?>

    <?php // echo $form->field($model, 'id_card_image') ?>

    <?php // echo $form->field($model, 'organization_id') ?>

    <?php // echo $form->field($model, 'nanny_id') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'slogan') ?>

    <?php // echo $form->field($model, 'id_status') ?>

    <?php // echo $form->field($model, 'verified') ?>

    <?php // echo $form->field($model, 'verified_reason') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'new_pop_url') ?>

    <?php // echo $form->field($model, 'is_share_sm') ?>

    <?php // echo $form->field($model, 's_status') ?>

    <?php // echo $form->field($model, 'is_fill_information') ?>

    <?php // echo $form->field($model, 'is_zombie') ?>

    <?php // echo $form->field($model, 'wechat_info') ?>

    <?php // echo $form->field($model, 'shut_up_count') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'temp') ?>

    <?php // echo $form->field($model, 'is_star') ?>

    <?php // echo $form->field($model, 'is_activity') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'online_state') ?>

    <?php // echo $form->field($model, 'is_fraud') ?>

    <?php // echo $form->field($model, 's_type') ?>

    <div class="clearfix form-group"></div>
    <div class="form-group col-lg-12">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>
    <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>

</div>
