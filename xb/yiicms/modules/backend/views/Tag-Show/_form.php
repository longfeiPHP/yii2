<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TagShow;
use app\models\TagList;
/* @var $this yii\web\View */
/* @var $model app\models\TagShow */
/* @var $form yii\widgets\ActiveForm */
$tagGropuList = TagList::AllGroupList();
$json = json_encode($tagGropuList);
?>

<div class="banner-form panel panel-default tag-list-form" style="padding-top: 15px;">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row "><div class="col-sm-12 " >
        <div class="col-sm-6">

            <?= $form->field($model, 'tag_app_key')->dropDownList(TagShow::$app) ?>
            <?= $form->field($model, 'tag_list_pid')->dropDownList($tagGropuList[0]) ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'tag_region_id')->dropDownList(TagShow::$region) ?>
            <?= $form->field($model, 'tag_list_id')->dropDownList([]) ?>
        </div>
    </div></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>'margin-left: 1%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var tagGropuList = <?php echo $json ;?>;
    $(function () {
        setSelect ();
    });
    function setSelect () {
        $('#tagshow-tag_list_id').empty();
        var pid = $('#tagshow-tag_list_pid').find("option:selected").val();
        var pidText = $('#tagshow-tag_list_pid').find("option:selected").text();

        $('#tagshow-tag_list_id').append("<option value='"+pid+"'>"+pidText+"</option>");
        if (typeof(tagGropuList[pid]) == "undefined" ){ 
            // console.log("null"); 
        }else{
           $.each(tagGropuList[pid], function(index, value) {
               $("#tagshow-tag_list_id").append("<option value='"+index+"'>"+value+"</option>"); 
            }); 
        }
        
    }
    $('#tagshow-tag_list_pid').change(function  () {
        setSelect ();
    })
</script>