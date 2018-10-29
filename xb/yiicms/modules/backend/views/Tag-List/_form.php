<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TagList;

/* @var $this yii\web\View */
/* @var $model app\models\TagList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form panel panel-default tag-list-form" style="padding-top: 15px;">

    <?php $form = ActiveForm::begin(
        [
            
        ]
    ); ?>
    <div class="col-sm-12 " >
        <div class="col-sm-6">

            <?= $form->field($model, 'pid')->dropDownList(TagList::PNameList()) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group" style="padding-left: 15px;">
        
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
