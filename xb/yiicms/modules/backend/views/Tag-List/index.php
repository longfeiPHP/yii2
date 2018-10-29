<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\TagListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标签列表';
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
                    <div class="form-group field-taglist-pid">
                        <label class="control-label" for="taglist-pid">父标签</label>
                        <select id="taglist-pid" class="form-control" name="TagList[pid]">
                            
                        </select>

                        <div class="help-block"></div>
                    </div>
                    <div class="form-group field-taglist-key required">
                        <label class="control-label" for="taglist-key">标签号</label>
                        <input type="text" id="taglist-key" class="form-control" name="TagList[key]" maxlength="32" aria-required="true">

                        <div class="help-block"></div>
                    </div>
                    <div class="form-group field-taglist-name required">
                        <label class="control-label" for="taglist-name">标签名称</label>
                        <input type="text" id="taglist-name" class="form-control" name="TagList[name]" maxlength="32" aria-required="true">

                        <div class="help-block"></div>
                    </div>
                    <div class="form-group field-taglist-title required">
                        <label class="control-label" for="taglist-title">标签主题</label>
                        <input type="text" id="taglist-title" class="form-control" name="TagList[title]" maxlength="64" aria-required="true">

                        <div class="help-block"></div>
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


<div class="tag-list-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建标签', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'options'=>['class' => 'panel panel-default'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'pid',
            [
                'attribute'=>'pid',
                'value'=>function ($dataProvider)
                {
                    $val ="";
                    if (!$dataProvider->pid ==0) {
                        $val = $dataProvider->pidName['name'];
                    }
                    return $val;
                }
            ],
            'key',
            'name',
            'title',
            // 'status',
            // 'updated_at',
            // 'created_at',

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

                   $('#editModal #taglist-key').val(data.data.key);
                   $('#editModal #taglist-name').val(data.data.name);
                   $('#editModal #taglist-title').val(data.data.title);
                   $('#editModal #taglist-pid').empty();
                   $.each(data.data.PNameList, function(index, value, array) {
                       jQuery("#editModal #taglist-pid").append("<option value='"+index+"'>"+value+"</option>"); 
                    });
                   $("#editModal #taglist-pid").val(data.data.pid);
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
        var key =$('#editModal #taglist-key').val();
        var name =$('#editModal #taglist-name').val();
        var title =$('#editModal #taglist-title').val();
        var pid =$('#editModal #taglist-pid').val();
        var id = $(this).data('id');
        console.log(id);
        if (!checkEmpty('#editModal #taglist-key')) {
            return false;
        };
        if (!checkEmpty('#editModal #taglist-name')) {
            return false;
        };
        if (!checkEmpty('#editModal #taglist-title')) {
            return false;
        };
        
        var params ={id:id,key:key,name:name,title:title,pid:pid};

        $.ajax({
            url:'update.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {

                if (data.code>0) { 
                    // alert(data.error);
                    resultTip('error','错误：'+data.error)
                    if (data.code==2) {
                        $('#editModal #taglist-key').parent().removeClass('has-success');
                        $('#editModal #taglist-key').parent().addClass('has-error');
                    };
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
