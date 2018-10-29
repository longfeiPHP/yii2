<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\PushMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推送消息列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal">

    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #367fa9;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">编辑推送消息</h4>
            </div>
            <div class="modal-body">
                    
                    <input type="hidden" name="_csrf" value="WUtNRFZyMjNregkgM0F1XmsOHh43N2pDLid5ABk3SwIpPgYFYyZ0dA==">
                    <div class="form-group field-pushmessage-type required">
                        <div class="col-lg-12">
                            <div class="row">
                                <span class="col-lg-2"><label class="control-label" for="pushmessage-type">推送帐号</label></span>
                                <span class="col-lg-8">
                                    <select id="pushmessage-type" class="form-control" name="PushMessage[type]" aria-required="true">
                                    
                                    </select>
                                </span>
                                <span class="col-lg-2"><div class="help-block"></div></span>
                            </div>
                        </div>
                    </div>        


                    <div class="form-group field-pushmessage-notity_content required">
                        <div class="col-lg-12">
                            <div class="row">
                                <span class="col-lg-2"><label class="control-label" for="pushmessage-notity_content">通知内容</label></span>
                                <span class="col-lg-8"><input type="text" id="pushmessage-notity_content" class="form-control" name="PushMessage[notity_content]" maxlength="512" aria-required="true"></span>
                                <span class="col-lg-2"><div class="help-block"></div></span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group field-pushmessage-notity_title required">
                        <div class="col-lg-12">
                            <div class="row">
                                <span class="col-lg-2"><label class="control-label" for="pushmessage-notity_title">通知标题</label></span>
                                <span class="col-lg-8"><input type="text" id="pushmessage-notity_title" class="form-control" name="PushMessage[notity_title]" maxlength="128" aria-required="true"></span>
                                <span class="col-lg-2"><div class="help-block"></div></span>
                            </div>
                        </div>
                    </div>        



                    <div class="form-group field-pushmessage-im_content required">
                        <div class="col-lg-12">
                            <div class="row">
                                <span class="col-lg-2"><label class="control-label" for="pushmessage-im_content">消息内容</label></span>
                                <span class="col-lg-8"><textarea id="pushmessage-im_content" class="form-control" name="PushMessage[im_content]" maxlength="512" style=" min-height:250px;overflow:auto;" aria-required="true"></textarea></span>
                                <span class="col-lg-2"><div class="help-block"></div></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group errorinfo" ><label class="control-label" ></label></div>

                    <div class="form-group ">
                        <button class="btn btn-success update">更新</button>
                        <button type="button" class="btn btn-danger btn-person" data-dismiss="modal"
                            aria-label="Close">关闭</button>
                    </div>

            </div>
        </div>
    </div>
</div>



<div class="push-message-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建推送', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>['class' => 'panel panel-default'],
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'type',
            [
                'attribute'=>'accountInfo.nickname',
                'label'=>'推送类型',
            ],
            'notity_title',
            'notity_content',
            'im_content',
            // 'status',
            'notity_result',
            // 'created_at',
            // 'updated_at',
            [
                'attribute'=>'updated_at',
                'label'=>'推送时间',
                'value' =>function ($dataProvider)
                {
                   if ($dataProvider->updated_at > 0) {
                       return date('Y-m-d H:i:s',$dataProvider->updated_at);
                   }else{
                    return "";
                   }
                }
                // 'format' =>['date','php:Y-m-d H:i:s'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{send}',
                'header' => '操作',
                'headerOptions'=>['style'=>'width:2%;'],
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
                    'send' => function ($url, $model, $key) { 
                    return Html::a('推送', 
                        '#', 
                        ['class' => 'btn  btn-success btn-xs send',
                        'title'=>'推送消息',
                        'data-id'=>$model->id,
                        ]); 
                    },
                ],
                'visibleButtons'=>[

                'send'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->updated_at === 0;
                    },
                'view'=>function ($model, $key, $index) {
                    //...coding                     
                    return $model->updated_at === 0;
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
            url:'view.html',
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

                   $('#editModal #pushmessage-im_content').val(data.data.im_content);
                   $('#editModal #pushmessage-notity_content').val(data.data.notity_content);
                   $('#editModal #pushmessage-notity_title').val(data.data.notity_title);
                   $('#editModal #pushmessage-type').empty();
                   $.each(data.data.typeList, function(index, value, array) {
                       jQuery("#editModal #pushmessage-type").append("<option value='"+index+"'>"+value+"</option>"); 
                    });
                   $("#editModal #pushmessage-type").val(data.data.type);
                   $('#editModal .update').attr('data-id',data.data.id);

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
        var im_content =$('#editModal #pushmessage-im_content').val();
        var notity_content =$('#editModal #pushmessage-notity_content').val();
        var notity_title =$('#editModal #pushmessage-notity_title').val();
        var type =$('#editModal #pushmessage-type').val();
        var id = $(this).data('id');
        console.log(id);
        if (!checkEmpty('#editModal #pushmessage-im_content')) {
            return false;
        };
        if (!checkEmpty('#editModal #pushmessage-notity_content')) {
            return false;
        };
        if (!checkEmpty('#editModal #pushmessage-notity_title')) {
            return false;
        };
        
        var params ={id:id,im_content:im_content,notity_content:notity_content,notity_title:notity_title,type:type};

        $.ajax({
            url:'update.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {

                if (data.code>0) { 
                    // alert(data.error);
                    resultTip('error','错误：'+data.error)

                }else{
                    // alert('修改成功！');
                    resultTip('success','成功：修改成功！');
                    // $('#editModal').modal('hide'); 
                    // $(".modal-backdrop").remove();
                    window.location.href=window.location.href;
                }
            },
            error:function (argument) {
                // alert('检查网络及权限！重试！');
                resultTip('error','错误：检查网络及权限！重试！');
            }
        })

        

    })

    $('.send').click(function (argument) {

        var id = $(this).data('id');       
        var params ={id:id};
        $(this).css('pointer-events','none');
        $(this).addClass('btn-default');
        $(this).removeClass('btn-success');

        if(!confirm('你确定要向用户推送该消息吗?')){
            $(this).css('pointer-events','auto');

            $(this).removeClass('btn-default');
            $(this).addClass('btn-success');
            return false;
        }

        $.ajax({
            url:'send.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {

                if (data.code>0) { 
                    alert(data.error);
                    // resultTip('error','错误：'+data.error)

                }else{
                    alert('修改成功！');
                    // resultTip('success','成功：修改成功！');
                    console.log(data);
                    // window.location.href=window.location.href;
                }
            },
            error:function (argument) {
                alert('检查网络及权限！重试！');
                // resultTip('error','错误：检查网络及权限！重试！');
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

    function resultTip (type,msg) {
        $('.errorinfo .control-label').html(msg);
        if (type=="error") {
            $('.errorinfo').removeClass('has-success');
            $('.errorinfo').addClass('has-error');
            return false;
        }else{
            $('.errorinfo').removeClass('has-error');
            $('.errorinfo').addClass('has-success');
            return true;
        };
    }

</script>