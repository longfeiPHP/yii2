<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use app\models\Banner;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$type_name = Banner::getBannerType()[$banner_type];
$this->title = $type_name.'管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #62a8ea;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">编辑信息</h4>
        </div>
        <div class="modal-body">
            <form id="w0" action="/backend/banner/create.html" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_csrf" value="LmE0MnZxd3MbN1BrMysfR1RYUXQkQT9KaCtuczQeNitaTHl4HxMZSg==">
                <div class="form-group field-banner-title">    
                    <div class='row'>
                        <span class='col-lg-2 '>活动标题</span>
                        <span class='col-lg-5'><input type="text" id="banner-title" class="form-control" name="Banner[title]" maxlength="100" aria-required="true"></span>
                        <span class='col-lg-4 error'></span>
                    </div>
                </div>
                <div class="form-group field-banner-img">    
                    <div class='row'>
                        <span class='col-lg-2 '>活动图</span>
                        <span class='col-lg-5'><input type="file" name="Banner[imageFile]" id="image_edit" data-plugin="dropify" data-default-file=""></span>
                        <span class='col-lg-4 error'></span>
                    </div>
                </div>
                <div class="form-group field-banner-jump_type">    
                    <div class='row'>
                        <span class='col-lg-2 '>跳转方式</span>
                        <span class='col-lg-5'>
                        <select id="banner-jump_type" class="form-control" name="Banner[jump_type]" aria-required="true">
                            <option value="">选择跳转方式</option>
                            <option value="3">动态变化</option>
                            <option value="1">H5链接</option>
                            <option value="2">直播间</option>
                            <option value="0">主播简介</option>
                        </select></span>
                        <span class='col-lg-4 error'></span>
                    </div>
                </div>
                <div class="form-group field-banner-sid">    
                    <div class='row'>
                        <span class='col-lg-2 '>主播ID</span>
                        <span class='col-lg-5'><input type="text" id="banner-sid" class="form-control" name="Banner[sid]" maxlength="32"></span>
                        <span class='col-lg-4 error'></span>
                    </div>
                </div>
                <div class="form-group field-banner-h5_url">    
                    <div class='row'>
                        <span class='col-lg-2 '>链接</span>
                        <span class='col-lg-5'><input type="text" id="banner-h5_url" class="form-control" name="Banner[h5_url]" maxlength="255" placeholder="http://开头"></span>
                        <span class='col-lg-4 error'></span>
                    </div>
                </div>
                <div class="form-group field-banner-banner_push">    
                    <div class='row'>
                        <span class='col-lg-2 '>弹出通知</span>
                        <span class='col-lg-5'>
                        <select id="banner-jump_type" class="form-control" name="Banner[banner_push]" aria-required="true">
                            <option value="">选择是否弹出通知</option>
                            <option value="1">显示</option>
                            <option value="0" selected="">不显示</option>
                        </select></span>
                        <span class='col-lg-4 error'></span>
                    </div>
                </div>
                <div class="form-group field-banner-show_start_time required">
                    <div class="row">
                    <span class="col-lg-2">展示开始</span>
                    <span class="col-lg-5">
                    <div id="banner-show_start_time-datetime" class="input-group date">
                    <span class="input-group-addon" title="日期和时间">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    <span class="input-group-addon" title="清除"><span class="glyphicon glyphicon-remove"></span></span><input type="text" id="banner-show_start_time" class="form-control" name="Banner[show_start_time]" placeholder="选择展示开始时间" aria-required="true" data-krajee-datetimepicker="datetimepicker_6e78d103"></div></span><span class="col-lg-4"><div class="help-block"></div></span></div></div>

            </form>
        </div>
    </div>
  </div>
</div>

<div class="banner-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加'.$type_name, ['create','banner_type'=>$banner_type], ['class' => 'btn btn-success']) ?>
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
            'title',
            
            // 'img',
            ['attribute'=>'img',
            'label'=>'活动图',
            'value'=>function($dataProvider){
                if (!empty($dataProvider->img)) {
                    $url = \yii::$app->params['imgcdn']. $dataProvider->img;
                    $options=[
                        'height'=>'30',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                    ];
                    return \yii\helpers\Html::img($url,$options);
                }
                return '';
                },
            'format'=>'raw'
            ],
            'sid',
            'h5_url',
            // 'jump_type',
            [
                'attribute'=>'jump_type',
                'label'=>'跳转方式',
                'value'=>function($dataProvider){
                    $val='';
                    //0-主播简介, 1-H5，2-直播间，3-动态变化
                    switch ($dataProvider->jump_type) {
                        case 0:
                            $val='主播简介';
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
                        return '否';
                    }else{
                       return'是'; 
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
                // 'format' =>['date','php:Y-m-d H:i:s'],
                'value' =>function($dataProvider){
                    return $dataProvider->live_start_time==0 ?  '': date('Y-m-d H:i:s',$dataProvider->live_start_time);
                    // return '';
                },
            ],
            // 'live_end_time:datetime',
            [
                'attribute'=>'live_end_time',
                'label'=>'活动结束',
                // 'format' =>['date','php:Y-m-d H:i:s'],
                'value' =>function($dataProvider){
                    return $dataProvider->live_end_time==0 ?  '': date('Y-m-d H:i:s',$dataProvider->live_end_time);
                    // return '';
                },
            ],
            // 'status',
            [
                'attribute'=>'status',
                'value'=>function($dataProvider){
                    if ($dataProvider->status==0) {
                        return '下线';
                    }else{
                       return'上线'; 
                   }
                }
            ],
            // 'created_at',
            // 'updated_at',

            [
            'class' => 'yii\grid\ActionColumn',

                'template' => '{up}{down}{del} {able}{view} ',
                'header' => '操作',
                'headerOptions'=>['style'=>'width:2%;'],
                'buttons' => [
                'up' => function ($url, $model, $key) { 
                    return "<a class='btn btn-block  btn-primary btn-xs up' data-id =$model->id  title='上移'>上移</a>";
                    },
                'down' => function ($url, $model, $key) { 
                    return "<a class='btn btn-block  btn-warning btn-xs down' data-id =$model->id  title='下移'>下移</a>";
                    },
                // 'down'=>array(
                //     'label'=>'下移',
                //     'url'=>'Yii::app()->controller->createUrl("edit", array("Id"=>$data->primaryKey))',
                // ), 
                'del' => function ($url, $model, $key) { 
                    return Html::a('下线', 
                        ['del','banner_type'=>$model->banner_type,'id'=>$model->id], 
                        ['class' => 'btn btn-danger btn-xs',
                        'title'=>'下线活动',
                        'data' => [
                            'confirm' => '你确定要下线此活动吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                'able' => function ($url, $model, $key) { 
                    return Html::a('上线', 
                        ['able','banner_type'=>$model->banner_type,'id'=>$model->id], 
                        ['class' => 'btn btn-success btn-xs',
                        'title'=>'上线活动',
                        'data' => [
                            'confirm' => '你确定要上线此活动吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                'view' => function ($url, $model, $key) { 
                    return Html::a('编辑', 
                        $url, 
                        ['class' => 'btn  btn-primary btn-xs',
                        'title'=>'编辑活动',
                        'data-id'=>$model->id,
                        'data-title'=>$model->title,
                        // 'data-toggle'=>"modal", 
                        // 'data-target'=>"#editModal",
                        ]); 
                    },
                ],
                'visibleButtons'=>[
                'del'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->status === 1;
                    },
                'able'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->status === 0;
                    },
                'up'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->status === 1;
                    },
                'down'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->status === 1;
                    },
                ],

            ],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    
    /*上移*/
    $('.up').on('click', function() {
        var $tr = $(this).parents("tr");
        var params ={id:$(this).data('id'),action:'up'};
        if ($tr.index() != 0) {
           
           $.ajax({
                url:'/backend/banner/sort.html',
                type:'POST',
                data:params,
                datatype:"json",
                success:function (data) {
                    if (data.code) {                      
                        
                        $tr.fadeOut().fadeIn();
                        $tr.prev().before($tr);
                            

                    }else{
                        alert(data.error);
                    };
                }
            })
        }else {
            alert('已经在最顶端了');
        };

    });

    /*下移*/
    $('.down').on('click', function() {
        var params ={id:$(this).data('id'),action:'down'}; 
        var len = $(".down").length;
        var $tr = $(this).parents("tr");
        if ($tr.index() != len - 1) {
            $.ajax({
                url:'/backend/banner/sort.html',
                type:'POST',
                data:params,
                datatype:"json",
                success:function (data) {
                    if (data.code) {                      
                        
                       $tr.fadeOut().fadeIn();
                       $tr.next().after($tr);
                            

                    }else{
                        alert(data.error);
                    };
                }
            }) 
        } 
        else {
            alert('已经在最底端了');
        };
        
    });



    function genForm (params) {
        var template="<div class='col-lg-12'><div class='row'><span class='col-lg-2'>{label}</span><span class='col-lg-5'>{input}</span><span class='col-lg-4'>{error}</span></div></div>";

    }


</script>
<?php include(dirname(dirname(__FILE__))."/common/ImageView.php") ?>
