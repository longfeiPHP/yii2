<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//     	'tableOptions' => ['name'=>'tabalse'],//table 属性
    	'filterRowOptions'=>['class' => 'filters'],//搜索框的class
    	'headerRowOptions' => ['class'=>'abc'],//排序行的属性
    	'id' => 'idss',//设置table外的div的id
    	'options' => ['name' => 'options'],//设置table外的div的属性
    	'pager' => [//分页样式调整
    		'activePageCssClass'=>'active',
    		'options' => ['class' => 'pagination'],
    	],
    	'showFooter' => false,//是否显示tfoot
    	'placeFooterAfterBody' => false,
    	'rowOptions' => ['name'=>'rowOptionsss'],//给每个tr加属性
    	'showHeader' => true,//是否显示表头(搜索行与th行)
    	'layout' => "{summary}\n{items}\n{pager}",//板块//layout有5个值，分别为{summary}、{errors}、{items}、{sorter}和{pager}。
    	'summary' => "{begin}-{end}-{count}-{totalCount}-{page}-{pageCount}",//数据的相关信息，行，页面，总数等
    	'summaryOptions' => ['class' => 'summarys'],
    	'afterRow' => function ()//每一行渲染后执行的方法
    	{
//     		return '<td>111</td>';
    	},
    	'beforeRow' => function ()//每一行渲染前执行的方法
    	{
//     		return '<td>222</td>';
    	},
    	'caption' => '表格的标题',//表格的标题
    	'captionOptions' => ['class'=>'capClass'],//表格的标题的html标签属性设置
    	'emptyCell' => '<p>null</p>',//单元格数据为空时显示的内容
    	'emptyText' => 'emptyText',//$dataProvider为空时显示的内容
        'columns' => [//设置的列(字段)
//             ['class' => 'yii\grid\SerialColumn'],//序号列
            [
            	'attribute'=>'id',
            	'contentOptions'=>['width'=>'30px'],
            ],
            'title',
        	[
        		'attribute'=>'authorName',
        		'label' => '作者',
        		'value'=>'author.nickname',
        	],
//             'content:ntext',
            'tags:ntext',
        	[
        		'attribute'=>'status',
        		'value'=>'status0.name',
        		'filter'=>Poststatus::find()
        			->select(['name', 'id'])
        			->orderBy('position')
        			->indexBy('id')
        			->column(),
        	],
            //'create_time:datetime',
//             'update_time:datetime',
			[
				'label' => '修改时间',
				'attribute'=>'update_time',
				'value' => function ($data) {
					return date('Y-m-d H:i:s',$data->update_time);
				},
			],

            ['class' => 'yii\grid\ActionColumn'],//动作列
        ],
    ]); ?>
</div>
<div class="other">other</div>
<script>
$(document).ready(function(){
	$(".other").click(function(e){
		alert('other');
	});
});
</script>