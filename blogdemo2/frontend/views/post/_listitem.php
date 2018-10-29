<?php

use yii\helpers\Html;

?>

<div class="post">
	<div class="title">
		<h2><a href="<?php echo $model->url;?>"><?php echo Html::encode($model->title);?></a></h2>
		
		<div class="author">
		<span class="glyphicon glyphicon-time" aria-hidden="true"><em><?php echo date('Y-m-d H:i:s',$model->create_time);?></em>&nbsp;&nbsp;</span>
		<span class="glyphicon glyphicon-user" aria-hidden="true"><em><?php echo Html::encode($model->author->nickname);?></em></span>
		</div>
	</div>
	
	<div class="content">
		<?php echo $model->beginning;?><?php echo Html::a("详情",Yii::$app->urlManager->createUrl(['post/detail','id'=>$model->id]));?>
	</div>
	
	<div class="nav">
		<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
		<?php //echo implode(' ', $model->tagLinks);?>
		<?php 
		foreach ($model->tagLinks as $link)
		{
			echo Html::a(Html::encode($link['tag']), $link['url']).' ';
		}
		?>
		<br />
		<?php echo Html::a("评论({$model->countComment})", $model->url.'#comments');?> | 最后修改于：<?php echo date('Y-m-d H:i:s',$model->update_time);?>
	</div>
</div>