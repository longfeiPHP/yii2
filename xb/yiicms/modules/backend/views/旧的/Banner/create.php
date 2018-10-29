<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = '创建Banner';
$this->params['breadcrumbs'][] = ['label' => 'Banner管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script type="text/javascript">
	
	$('#banner-jump_type').change(function(){
		/*
		var sel_val=$('#banner-jump_type').val();
		
		$('.field-banner-sid ,.field-banner-h5_url ,.field-banner-live_start_time ,.field-banner-live_end_time').hide();
		$('#w0').yiiActiveForm('remove', "banner-live_start_time");
		$('#w0').yiiActiveForm('remove', "banner-live_end_time");
		$('#w0').yiiActiveForm('remove', "banner-sid");
		$('#w0').yiiActiveForm('remove', "banner-h5_url");

		if (sel_val==3) {
			$('.field-banner-sid ,.field-banner-h5_url ,.field-banner-live_start_time ,.field-banner-live_end_time').show();
			add_rule("live_start_time","科普开始时间必填。");
			add_rule("live_end_time","科普结束时间必填。");
			add_rule("sid","医生Id必填。");
			add_url_rule("h5_url","跳转链接必填。");
        }else if (sel_val==1) {
			$('.field-banner-h5_url').show();
			add_url_rule("h5_url","跳转链接必填。");
        }else if (sel_val==2) {
			$('.field-banner-sid ,.field-banner-live_start_time ,.field-banner-live_end_time').show();
			add_rule("live_start_time","科普开始时间必填。");
			add_rule("live_end_time","科普结束时间必填。");
			add_rule("sid","医生Id必填。");
        }else if (sel_val==0) {
			$('.field-banner-sid ').show();
			add_rule("sid","医生Id必填。");
        };*/

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
