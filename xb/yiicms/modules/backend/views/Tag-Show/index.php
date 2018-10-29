<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TagShow;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\TagShowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标签展示管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal">

    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #367fa9;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">编辑标签</h4>
            </div>
            <div class="modal-body">
                    
                    <input type="hidden" name="_csrf" value="WUtNRFZyMjNregkgM0F1XmsOHh43N2pDLid5ABk3SwIpPgYFYyZ0dA==">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class="col-sm-6">
                                <div class="form-group field-tagshow-tag_app_key">
                                    <label class="control-label" for="tagshow-tag_app_key">app标识</label>
                                    <select id="tagshow-tag_app_key" class="form-control" name="TagShow[tag_app_key]">
                    
                                    </select>
                                </div>
                                <div class="form-group field-tagshow-tag_list_pid">
                                    <label class="control-label" for="tagshow-tag_list_pid">父标签</label>
                                    <select id="tagshow-tag_list_pid" class="form-control" name="TagShow[tag_list_pid]">

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group field-tagshow-tag_region_id">
                                    <label class="control-label" for="tagshow-tag_region_id">归属区域</label>
                                    <select id="tagshow-tag_region_id" class="form-control" name="TagShow[tag_region_id]">
     
                                    </select>
                                </div>
                                <div class="form-group field-tagshow-tag_list_id required">
                                    <label class="control-label" for="tagshow-tag_list_id">标签名称</label>
                                    <select id="tagshow-tag_list_id" class="form-control" name="TagShow[tag_list_id]" aria-required="true">
                                        
                                    </select>

                                </div>
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

<div class="tag-show-index ">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('指派标签', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'options'=>['class' => 'panel panel-default'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'tag_app_key',
            [
                'attribute' =>'tag_app_key',
                'label'=>'显示app',
                'value'=>function($dataProvider)
                {
                    $val = TagShow::getAppName($dataProvider->tag_app_key);
                    return $val;
                    // return "";
                }
            ],
            // 'tag_region_id',
            [
                // 'attribute' => 'tag_region_id',
                'label'=>'显示区域',
                'value'=>function($dataProvider){return '中国';},
            ],
            // 'tag_list_id',
            [
                'attribute' => 'tagInfo.name',
                'label'=>'标签名称',
                // 'value'=>'中国'
            ],
            // 'sort',
            // 'status',
            [
                'attribute'=>'status',
                'value'=>function($dataProvider){
                    if ($dataProvider->status==0) {
                        return '未上线';
                    }else{
                       return'已上线'; 
                   }
                }
            ],
            // 'is_empty',
            // 'updated_at',
            // 'created_at',

            [
            'class' => 'yii\grid\ActionColumn',

                'template' => '{up}{down}',
                'header' => '排序',
                'headerOptions'=>['style'=>'width:2%;'],
                'buttons' => [
                'up' => function ($url, $model, $key) { 
                    return "<a class='btn  btn-primary btn-xs up' data-id =$model->id  title='上移'>上移</a>";
                    },
                'down' => function ($url, $model, $key) { 
                    return "<a class='btn  btn-warning btn-xs down' data-id =$model->id  title='下移'>下移</a>";
                    },
                ],
                'visibleButtons'=>[

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
            [
            'class' => 'yii\grid\ActionColumn',

                'template' => '{up}{down}{del} {able}{view} ',
                'header' => '操作',
                'headerOptions'=>['style'=>'width:2%;'],
                'buttons' => [
 
                'del' => function ($url, $model, $key) { 
                    return Html::a('下线', 
                        ['del','id'=>$model->id], 
                        ['class' => 'btn   btn-danger btn-xs',
                        'title'=>'下线活动',
                        'data' => [
                            'confirm' => '你确定要下线此活动吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                'able' => function ($url, $model, $key) { 
                    return Html::a('上线', 
                        ['able','id'=>$model->id], 
                        ['class' => 'btn  btn-success btn-xs',
                        'title'=>'上线活动',
                        'data' => [
                            'confirm' => '你确定要上线此活动吗?',
                            'method' => 'post',
                            ],
                        ]); 
                    },
                'view' => function ($url, $model, $key) { 
                    return Html::a('编辑', 
                        '#', 
                        ['class' => 'btn  btn-primary btn-xs',
                        'title'=>'编辑活动',
                        'data-id'=>$model->id,
                        // 'data-title'=>$model->title,
                        'data-toggle'=>"modal", 
                        'data-target'=>"#editModal",
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
                ],

            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    var tagGropuList;
    function setSelect () {
        $('#tagshow-tag_list_id').empty();
        var pid = $('#tagshow-tag_list_pid').find("option:selected").val();
        var pidText = $('#tagshow-tag_list_pid').find("option:selected").text();

        $('#tagshow-tag_list_id').append("<option value='"+pid+"'>"+pidText+"</option>");
        if (typeof(tagGropuList[pid]) == "undefined" ){ 
            // console.log("null"); 
        }else{
           $.each(tagGropuList[pid], function(index, value) {
               $("#tagshow-tag_list_id").append("<option value='"+index+"'>"+value+"</option>"); 
            }); 
        }
        
    }
    $('#tagshow-tag_list_pid').change(function  () {
        setSelect ();
    })

    /*上移*/
    $('.up').on('click', function() {
        var $tr = $(this).parents("tr");
        var params ={id:$(this).data('id'),action:'up'};
        if ($tr.index() != 0) {
           
           $.ajax({
                url:'sort.html',
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
                url:'sort.html',
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
                    console.log(data);
                    tagGropuList = data.data.tagGropuList;
                    
                   $('#editModal #tagshow-tag_region_id').empty();
                   $.each(data.data.regionName, function(index, value, array) {
                       jQuery("#editModal #tagshow-tag_region_id").append("<option value='"+index+"'>"+value+"</option>"); 
                    });
                   $("#editModal #tagshow-tag_region_id").val(data.data.tag_region_id);

                   $('#editModal #tagshow-tag_app_key').empty();
                   $.each(data.data.appName, function(index, value, array) {
                       jQuery("#editModal #tagshow-tag_app_key").append("<option value='"+index+"'>"+value+"</option>"); 
                    });
                   $("#editModal #tagshow-tag_app_key").val(data.data.tag_app_key);

                   $('#editModal #tagshow-tag_list_pid').empty();
                   console.log(data.data.tagGropuList,data.data.tagGropuList[0]);
                   $.each(data.data.tagGropuList[0], function(index, value, array) {
                       jQuery("#editModal #tagshow-tag_list_pid").append("<option value='"+index+"'>"+value+"</option>"); 
                    });
                   if (data.data.tagInfo.pid==0) {
                        $("#editModal #tagshow-tag_list_pid").val(data.data.tag_list_id);
                   }else{
                        $("#editModal #tagshow-tag_list_pid").val(data.data.tagInfo.pid); 
                   };
                   
                   setSelect ();
                   $("#editModal #tagshow-tag_list_id").val(data.data.tag_list_id);

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
        var tag_list_pid =$('#editModal #tagshow-tag_list_pid').val();
        var tag_list_id =$('#editModal #tagshow-tag_list_id').val();
        var tag_app_key =$('#editModal #tagshow-tag_app_key').val();
        var tag_region_id =$('#editModal #tagshow-tag_region_id').val();
        var id = $(this).data('id');
        console.log(id);
        
        var params ={id:id,tag_list_pid:tag_list_pid,tag_list_id:tag_list_id,tag_app_key:tag_app_key,tag_region_id:tag_region_id};

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