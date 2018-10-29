<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ShareInfo;

/* @var $this yii\web\View */
/* @var $model app\modules\backend\models\ShareInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="share-info-search panel panel-default">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'fieldConfig' => ['template'=>"<div class='col-lg-4'><div class='row'><span class='col-lg-3'>{label}</span><span class='col-lg-9'>{input}</span></div></div>"],
        'method' => 'get',
    ]); ?>



    <?php 

    $tempArr=ShareInfo::$eventList;
    $tempArr[""]='全部';
    ksort($tempArr);
    echo $form->field($model, 'event')->dropDownList($tempArr); ?>

    <?php 

    $tempArr=ShareInfo::getPlatName();
    $tempArr[""]='全部';
    ksort($tempArr);
    echo $form->field($model, 'platform')->dropDownList($tempArr); ?>


    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
