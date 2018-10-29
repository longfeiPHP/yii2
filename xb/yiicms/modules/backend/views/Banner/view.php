<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

// $this->title = $model->title;
$this->title = '修改';
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-view">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script type="text/javascript">
    var jump_type= <?=$model->jump_type ?>;
    $(function () { 

        if (jump_type==3) {
            $('.field-banner-sid ,.field-banner-h5_url ,.field-banner-live_start_time ,.field-banner-live_end_time,.field-banner-banner_push').show();

        }else if (sel_val==1) {
            $('.field-banner-h5_url').show();

        }else if (sel_val==2) {
            $('.field-banner-sid ,.field-banner-live_start_time ,.field-banner-live_end_time,.field-banner-banner_push').show();

        }else if (sel_val==0) {
            $('.field-banner-sid ').show();

        };

        $('#banner-live_start_time').change(function(){
            add_rule("live_start_time","科普开始时间必填。");
        });
        $('#banner-live_end_time').change(function(){
            add_rule("live_end_time","科普结束时间必填。");
        });
        $('#banner-sid').change(function(){
            add_rule("sid","医生Id必填。");
        });
        $('#banner-banner_push').change(function(){
            add_rule("banner_push","必选。");
        });
        $('#banner-h5_url').change(function(){
            add_rule("h5_url","跳转链接必填。");
        });
    });
    
</script>