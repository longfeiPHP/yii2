<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use common\models\Post;
use frontend\components\TagsCloudWidget;
use frontend\components\RctReplyWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

	<div class="row">
	
		<div class="col-md-9">
		<?php echo ListView::widget([
			'id' => 'postList',
			'dataProvider' => $dataProvider,
			'itemView' => '_listitem',
			'layout' => '{items}{pager}',
			'pager' => [
				'maxButtonCount' => 10,
				'nextPageLabel' => Yii::t('app', '下一页'),
				'prevPageLabel' => Yii::t('app', '上一页'),
			]
		]);?>
		</div>
		
		<div class="col-md-3">
			<div class="searchbox">
				<ul class="list-group">
				  <li class="list-group-item">
				  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查找文章（
				  <?php 
				  //数据缓存示例代码
				  /*
				  $data = Yii::$app->cache->get('postCount');
				  $dependency = new DbDependency(['sql'=>'select count(id) from post']);
				  
				  if ($data === false)
				  {
				  	$data = Post::find()->count();  sleep(5);
				  	Yii::$app->cache->set('postCount',$data,600,$dependency); //设置缓存60秒后过期
				  }
				  
				  echo $data;
				  */
				  ?>
				  <?php 
				  	$data = Yii::$app->cache->get("PostCount");
				  	if ($data === false)
				  	{
				  		$data = Post::find()->count();
				  		sleep(5);
				  		Yii::$app->cache->set('postCount',$data,2);
				  	}
				  	echo $data;
				  ?>
				  ）
				  </li>
				  <li class="list-group-item">				  
					  <form class="form-inline" action="<?= Yii::$app->urlManager->createUrl(['post/index']);?>" id="w0" method="get">
						  <div class="form-group">
						    <input type="text" class="form-control" name="PostSearch[title]" id="w0input" placeholder="按标题">
						  </div>
						  <button type="submit" class="btn btn-default">搜索</button>
					</form>
				  
				  </li>
				</ul>			
			</div>
			
			<div class="tagcloudbox">
				<ul class="list-group">
				  <li class="list-group-item">
				  <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> 标签云
				  </li>
				  <li class="list-group-item">
				  <?php 
				  //片段缓存示例代码
				  /*
				  $dependency = new DbDependency(['sql'=>'select count(id) from post']);
				  
				  if ($this->beginCache('cache',['duration'=>600],['dependency'=>$dependency]))
				  {
				  	echo TagsCloudWidget::widget(['tags'=>$tags]);
				  	$this->endCache();
				  }
				  */
				  ?>
				  <?= TagsCloudWidget::widget(['tags'=>$tags]);?>
				   </li>
				</ul>			
			</div>
			
			<div class="commentbox">
				<ul class="list-group">
				  <li class="list-group-item">
				  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 最新回复
				  </li>
				  <li class="list-group-item">
				  <?= RctReplyWidget::widget(['recentComments'=>$recentComments])?>
				  </li>
				</ul>			
			</div>
		</div>
	
	</div>

</div>