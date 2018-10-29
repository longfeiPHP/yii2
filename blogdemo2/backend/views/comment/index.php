<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use common\models\Commentstatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php 
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    	'emptyText' => '当前没有内容',
    	'rowOptions' => function ($model, $key, $index){//给每个tr加id属性
	    	if($index%2 === 0){
	    		return [
	    			'id'=>"tr-".$model->id,
	    			'style'=>'background:#ccc'
	    		];
	    	}else {
    			return ['id'=>"tr-".$model->id];
	    	}
    	},
    	'showFooter'=>true,
    	'showHeader'=>true,//是否显示表头默认true
    	'layout' => "{summary}\n{items}\n{pager}",//layout有5个值，分别为{summary}、{errors}、{items}、{sorter}和{pager}。
        'caption' => '评论列表',
        'columns' => [
//             [
//             	'class' => 'yii\grid\SerialColumn',
//             	'footerOptions' => ['colspan'=>2],
// 				'footer' => '删除全部'
//             ],

//             'id:text',
        	[
        		'attribute' => 'id',
        		'contentOptions' => ['width'=>'30px'],
        	],
//             'content:ntext',
			[
				'attribute' => 'content',
// 				'value' => function ($model){
// 					$tmpStr = strip_tags($model->content);
// 					$tmpLen = mb_strlen($tmpStr);
					
// 					return mb_substr($tmpStr, 0, 20,'utf-8').(($tmpLen>20)?'...':'');
// 				}
				'value' => 'beginning',
			],
        	[
        		'attribute' => 'status',
        		'value' => 'status0.name',
        		'filter' => Commentstatus::find()
        		->select(['name', 'id'])
        		->orderBy('position')
        		->indexBy('id')
        		->column(),
        		'contentOptions' => function($model)
        		{
    				return $model->status==1?['class'=>'bg-danger']:[];    		
	        	}
        	],
			[
				'attribute'=>'create_time',
				'value' => function ($data) {
					return date('Y-m-d H:i:s',$data->create_time);
				},
			],
//             'userid',
			[
				'attribute' => 'userName',
				'label' => '用户',
				'value' => 'user.username',
			],
            'email:email',
//             'url:url',
//             'post_id',
            [
            	'attribute' => 'postTitle',
            	'label' => '文章',
            	'value' => 'post.title',
            ],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{view}{update}{delete}{approve}',
            	'buttons' =>[
            		'approve' => function ($url, $model, $key)
            		{
            			$options = [
            				'title' => Yii::t('yii', '审核'),
            				'arid-label' => Yii::t('yii', '审核'),
            				'data-confirm' => Yii::t('yii', '你确定要通过这条评论吗？'),
            				'data-method' => 'post',
            				'data-ajax' => '0',
            			];
            			return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, $options);
            		}
            	],
            ],
        ],
    ]); ?>
</div>
