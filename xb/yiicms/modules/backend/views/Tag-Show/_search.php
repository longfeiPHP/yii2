<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TagShow;
/* @var $this yii\web\View */
/* @var $model app\modules\backend\models\TagShowSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-search panel panel-default tag-show-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => ['template'=>"<div class='col-lg-4'><div class='row'><span class='col-lg-3'>{label}</span><span class='col-lg-9'>{input}</span></div></div>"]

    ]); ?>


    <?= $form->field($model, 'tag_app_key')->dropDownList(TagShow::getAppName()) ?>

    <?= $form->field($model, 'tag_region_id')->dropDownList(TagShow::getRegionName()) ?>

    <?= $form->field($model, 'tag_list_id')->dropDownList(TagShow::getTag0()) ?>

    

    <div class="form-group">

        <?= Html::submitButton('查找', ['class' => 'btn btn-primary' ,'style'=>'margin-left: 1%;']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
