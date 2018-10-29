<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banner管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'options'=>['class' => 'panel panel-default'],
        'headerRowOptions' => ['class' => 'active','style'=>''],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            ['class' => CheckboxColumn::className()],
            // 'id',
            'sid',
            // 'img',
            ['attribute'=>'img',
            'label'=>'活动图',
            'format' => [
                'image', 
                [
                // 'width'=>'30',
                'height'=>'30',
                'class'=>'ab'
                ]
                ]],
            'title',
            'h5_url',
            // 'jump_type',
            [
                'attribute'=>'jump_type',
                'label'=>'跳转方式',
                'value'=>function($dataProvider){
                    $val='';
                    //0-医生简介, 1-H5，2-直播间，3-动态变化
                    switch ($dataProvider->jump_type) {
                        case 0:
                            $val='医生简介';
                            break;
                        case 1:
                            $val='H5页面';
                            break;
                        case 2:
                            $val='直播间';
                            break;
                        case 3:
                            $val='动态变化';
                            break;
                    }
                    return $val;
                }
            ],
            // 'banner_type',
            // 'banner_push',
            [
                'attribute'=>'banner_push',
                'label'=>'弹出通知',
                'value'=>function($dataProvider){
                    if ($dataProvider->banner_push==0) {
                        return '是';
                    }else{
                       return'否'; 
                   }
                }
            ],
            // 'banner_sort',
            // 'show_start_time:datetime',
            [
                'attribute'=>'show_start_time',
                'label'=>'展示开始',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            // 'show_end_time:datetime',
            [
                'attribute'=>'show_end_time',
                'label'=>'展示结束',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            // 'live_start_time:datetime',
            [
                'attribute'=>'live_start_time',
                'label'=>'活动开始',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            // 'live_end_time:datetime',
            [
                'attribute'=>'live_end_time',
                'label'=>'活动结束',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',

                'template' => '{del} {view} ',
                'header' => '操作',
                'buttons' => [
                'del' => function ($url, $model, $key) { 
                    return Html::a('下线', 
                        ['del'], 
                        ['class' => 'btn btn-block  btn-danger btn-xs',
                        'title'=>'下线活动',
                        'data' => [
                            'confirm' => '你确定要删除此记录吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                'view' => function ($url, $model, $key) { 
                    return Html::a('编辑', 
                        ['view'], 
                        ['class' => 'tn  btn-block btn-primary btn-xs',
                        'title'=>'编辑活动',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#editModal",
                        ]); 
                    },
                ],

            ],
        ],
    ]); ?>
</div>
