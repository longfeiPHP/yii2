<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \app\modules\backend\assets\BackendAsset;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\ChannelSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '频道主题';
$this->params['breadcrumbs'][] = $this->title;
BackendAsset::addScript($this,'@web/themes/default/css/laydate/laydate.js'); 
// BackendAsset::addCss($this,'@web/css/font-awesome/css/font-awesome.min.css'); 
?>


<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal">

    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #367fa9;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">编辑主题</h4>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="_csrf" value="WUtNRFZyMjNregkgM0F1XmsOHh43N2pDLid5ABk3SwIpPgYFYyZ0dA==">
                    <!-- <div class="form-group field-channelsubject-channel_key">
                        <label class="control-label" for="channelsubject-channel_key">频道Key</label>
                        <input type="text" id="channelsubject-channel_key" class="form-control" name="ChannelSubject[channel_key]" maxlength="16">

                        <div class="help-block"></div>
                    </div> -->
                    <div class="form-group field-channelsubject-channel_title col-lg-12">
                        <label class="control-label" for="channelsubject-channel_title">默认标题</label>
                        <input type="text" id="channelsubject-channel_title" class="form-control" name="ChannelSubject[channel_title]" maxlength="100" aria-invalid="false">

                        <div class="help-block"></div>
                    </div>
                    <div class="form-group field-channelsubject-active_title col-lg-12">
                        <label class="control-label" for="channelsubject-active_title">活动标题</label>
                        <input type="text" id="channelsubject-active_title" class="form-control" name="ChannelSubject[active_title]" maxlength="100">

                        <div class="help-block"></div>
                    </div>
                    <div class="col-lg-12 ">
                        <div class="form-group field-channelsubject-show_start_time col-lg-6 row">
                            <label class="control-label" for="channelsubject-show_start_time">开始时间</label>
                            <input type="text" id="channelsubject-show_start_time" class="form-control" name="ChannelSubject[show_start_time]">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group field-channelsubject-show_end_time  col-lg-6">
                            <label class="control-label" for="channelsubject-show_end_time">结束时间</label>
                            <input type="text" id="channelsubject-show_end_time" class="form-control" name="ChannelSubject[show_end_time]">

                            <div class="help-block"></div>
                        </div>
                    </div>
                    
                    

                    <div class="form-group ">
                        <button class="btn btn-success update">更新</button>
                        <button type="button" class="btn btn-primary btn-person" data-dismiss="modal"
                            aria-label="Close">关闭</button>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="channel-subject-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新频道', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'options'=>['class' => 'panel panel-default'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'channel_key',
            'channel_title',
            'active_title',
            //  'show_start_time:datetime',
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
            // 'status',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} ',
                'header' => '操作',
                'buttons' => [
                    'view' => function ($url, $model, $key) { 
                        return Html::a('编辑', 
                            '#', 
                            ['class' => 'btn  btn-primary btn-xs',
                            'title'=>'编辑',
                            'data-id'=>$model->id,
                            'data-toggle'=>"modal", 
                            'data-target'=>"#editModal",
                            ]); 
                        },
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">

    $('#editModal').on('show.bs.modal', function (event) {
        // console.log($(event.relatedTarget)); 
      // var id = $(event.relatedTarget).data('id');
      var button = $(event.relatedTarget) // 触发事件的按钮  
      var id = button.data('id') // 解析出data-whatever内容
      var params ={id:id};

        $.ajax({
            url:'/backend/channel-subject/view.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {

                if (data.code==1) { 
                    $('#editModal').modal('hide'); 
                    $(".modal-backdrop").remove(); 
                    setTimeout(function  (argument) {
                        alert(data.error);
                    },300)                      
                }else{

                   $('#editModal .modal-title').html('编辑主题-频道Key:'+data.data.channel_key);
                   $('#editModal #channelsubject-channel_title').val(data.data.channel_title);
                   $('#editModal #channelsubject-active_title').val(data.data.active_title);
                   console.log($('#editModal .update'));
                   $('#editModal .update').attr('data-id',data.data.id);
                   laydate.render({
                      elem: '#channelsubject-show_end_time', //指定元素
                      type: 'datetime',
                      value: data.data.show_end_time
                    });
                    laydate.render({
                      elem: '#channelsubject-show_start_time', //指定元素
                      type: 'datetime',
                      value: data.data.show_start_time
                    });
                   
                   // $('#editModal #channelsubject-show_start_time').html();
                   // $('#editModal #channelsubject-show_end_time').html();
                }
            },
            error:function (argument) {
                $('#editModal').modal('hide'); 
                $(".modal-backdrop").remove();
                setTimeout(function  (argument) {
                    alert('检查网络及权限！重试！');
                },300)
                
            }
        }) 


    });

    $('.update').click(function (argument) {
        var channel_title =$('#editModal #channelsubject-channel_title').val();
        var active_title =$('#editModal #channelsubject-active_title').val();
        var show_end_time =$('#editModal #channelsubject-show_end_time').val();
        var show_start_time =$('#editModal #channelsubject-show_start_time').val();
        var id = $(this).data('id');
        console.log(id);
        if (!checkEmpty('#editModal #channelsubject-channel_title')) {
            return false;
        };
        if (!checkEmpty('#editModal #channelsubject-active_title')) {
            return false;
        };
        if (!checkEmpty('#editModal #channelsubject-show_end_time')) {
            return false;
        };
        if (!checkEmpty('#editModal #channelsubject-show_start_time')) {
            return false;
        };
        var params ={id:id,channel_title:channel_title,active_title:active_title,show_end_time:show_end_time,show_start_time:show_start_time};

        $.ajax({
            url:'/backend/channel-subject/update.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {

                if (data.code==1) { 
                    alert(data.error);                     
                }else{
                    alert('修改成功！');
                    // $('#editModal').modal('hide'); 
                    // $(".modal-backdrop").remove();
                    window.location.href=window.location.href;
                }
            },
            error:function (argument) {
                alert('检查网络及权限！重试！');
                
            }
        })

        

    })

    function checkEmpty (selector) {
        var mycontent = $(selector).val().trim();
        if (mycontent=="") {
            $(selector).parent().removeClass('has-success');
            $(selector).parent().addClass('has-error');
            return false;
        }else{
            $(selector).parent().removeClass('has-error');
            $(selector).parent().addClass('has-success');
            return true;
        };
    }
</script>


