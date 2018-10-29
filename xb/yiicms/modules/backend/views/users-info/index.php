<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\UsersInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '医生认证';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #62a8ea;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">图片预览</h4>
            <h5 id="next_title"></h5>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="form-group text-center">
                    
                    <div class="col-sm-9" id="next_page">
                       <!-- <img id='card0' width='283' height='350' src=''/>
                       <img id='card1' width='283' height='350' src='' style="display:none"/>
                       <img id='card2' width='283' height='350' src='' style="display:none"/> -->
                    </div>
                    <button data-angle='0' id="round_image" class="btn btn_round" type="button" value="旋转">
                       <i class="glyphicon glyphicon-repeat" aria-hidden="true"></i></button>
                    <br>
                    <br>
                    <button data-num='0' id="up_image" class="btn btn_up" type="button">
                        上一张</button>
                    <br>
                    <br>
                    <button data-num='0' id="down_image" class="btn btn_next" type="button">
                        下一张</button>

                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModal">

    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #d73925;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">医生实名认证</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">请填写打回的原因</label>

                        <div class="col-sm-8">
                            <input   type="text" class="form-control" name="verified_reason" id="verified_reason" value=""/>
                        </div>
                        <div class="col-sm-1 error_div" style="color: #d73925;">
                            
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button id="submitverify" data-id="" data-type="" type="button" class="btn btn-primary btn-person verify" onclick="">提交</button>
                        <button type="button" class="btn btn-primary btn-person" data-dismiss="modal"
                                aria-label="Close">取消
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="hisModal" tabindex="-1" role="dialog" aria-labelledby="hisModal">

    <div class="modal-dialog " role="document" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #62a8ea;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">审核流水</h4>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 15%;">日期</th>
                                <th style="width: 10%;">操作员</th>
                                <th style="width: 10%;">操作</th>
                                <th>理由</th>
                            </tr>
                        </thead>
                        <tbody class="his-body">
                            
                        </tbody>
                    </table>
                </div>
               <!--  <div class="form-group text-center">
                    
                    <button type="button" class="btn btn-primary btn-person" data-dismiss="modal"
                            aria-label="Close">关闭</button>
                </div> -->

            </div>
        </div>
    </div>
</div>

<div class="users-info-index">
<!--  
    <h1><?= Html::encode($this->title) ?></h1>-->
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'options'=>['class' => 'panel panel-default'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'uid',
            // 'sid',
            'mobile',
            'realname',
            // 'stype',
            ['attribute'=>'stype',
                'value'=>function($dataProvider){
                    $val='';
                    switch ($dataProvider->stype) {
                        case 1:
                            $val='中医';
                            break;
                        case 2:
                            $val='西医';
                            break;
                        default:
                            $val='未知';
                    }
                    return $val;
                }
            ],
            // 'id_status',
            ['attribute'=>'id_status',
                'format'=>'raw',
                'value'=>function($dataProvider){
                    $val='';
                    switch ($dataProvider->id_status) {
                        case 0:
                            $val="<span style='color:red;' id='status$dataProvider->id'>未审</span>";
                            break;
                        case 1:
                            $val="<span style='color:#008d4c;' id='status$dataProvider->id'>已审</span>";
                            break;
                        case 2:
                            $val="<span style='color:#000000;' id='status$dataProvider->id'>驳回</span>";
                            break;
                    }
                    return $val;
                },

            ],
            'id_card_type',
            'id_card_no',
            // 'id_card_img',
            ['attribute'=>'id_card_img',
            'label'=>'身份证',
            'contentOptions'=>['style'=>'width:110px'],
            'value'=>function($dataProvider){
                $res='';
                if (!empty($dataProvider->id_card_usr_img)) {
                    $url = \yii::$app->params['imgcdn']. $dataProvider->id_card_usr_img;
                    $options=[
                        'height'=>'30',
                        'class'=>'td_img',
                        'data-d1'=>$dataProvider->realname,
                        'data-d2'=>$dataProvider->id_card_type,
                        'data-d3'=>$dataProvider->id_card_no,
                        'data-d4'=>'card',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                    ];
                    $res = \yii\helpers\Html::img($url,$options);
                }
                if (!empty($dataProvider->id_card_img)) {
                    $url = \yii::$app->params['imgcdn']. $dataProvider->id_card_img;
                    $options=[
                        'height'=>'30',
                        'class'=>'td_img',
                        'data-d1'=>$dataProvider->realname,
                        'data-d2'=>$dataProvider->id_card_type,
                        'data-d3'=>$dataProvider->id_card_no,
                        'data-d4'=>'card',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                    ];
                    $res = \yii\helpers\Html::img($url,$options);
                }
                if (!empty($dataProvider->id_card_bg_img)) {
                    $url = \yii::$app->params['imgcdn']. $dataProvider->id_card_bg_img;
                    $options=[
                        'height'=>'30',
                        'class'=>'td_img',
                        'data-d1'=>$dataProvider->realname,
                        'data-d2'=>$dataProvider->id_card_type,
                        'data-d3'=>$dataProvider->id_card_no,
                        'data-d4'=>'card',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                    ];
                    $res .= \yii\helpers\Html::img($url,$options);
                }
                if (!empty($dataProvider->real_card_img)) {
                    $url = \yii::$app->params['imgcdn']. $dataProvider->real_card_img;
                    $options=[
                        'height'=>'30',
                        'class'=>'td_img',
                        'data-d1'=>$dataProvider->realname,
                        'data-d2'=>$dataProvider->id_card_type,
                        'data-d3'=>$dataProvider->id_card_no,
                        'data-d4'=>'card',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                    ];
                    $res .= \yii\helpers\Html::img($url,$options);
                }
                return $res;
                },
            'format'=>'raw'
            ],
            // 'id_card_bg_img',
            // 'id_card_usr_img',
            // 'real_card_img',
            // 'hospital_id',
            ['attribute'=>'hospital.name',
                'label'=>'医院',
            ],
            // 'department_id',
            ['attribute'=>'department.name',
                'label'=>'科室',
            ],
            // 'jobtitle_id',
            ['attribute'=>'jobtitle.name',
                'label'=>'职称',
            ],
            // 'reg_cert_img',
            ['attribute'=>'reg_cert_img',
                'contentOptions'=>['style'=>'width:110px'],
                'value'=>function ($dataProvider)
                {
                    
                    if (strlen( $dataProvider->reg_cert_img) > 0) {
                        $ar=explode( ';',$dataProvider->reg_cert_img);
                        $temp='';
                        foreach ($ar as $key => $value) {

                            $temp.= Html::img(\yii::$app->params['imgcdn'].$value, 
                                ['width'=>'30px',
                                'class'=>'td_img',
                                'data-d1'=>$dataProvider->hospital->name,
                                'data-d2'=>$dataProvider->department->name,
                                'data-d3'=>$dataProvider->jobtitle->name,
                                'data-d4'=>'job',
                                'data-toggle'=>"modal", 
                                'data-target'=>"#myModal",
                                ]);
                        }
                        return $temp;
                    }else{
                        return '';
                    }
                },
                 'format'=>'raw',
                
            ],
            // 'job_title_img',
            ['attribute'=>'job_title_img',
                'contentOptions'=>['style'=>'width:110px'],
                'value'=>function ($dataProvider)
                {
                    
                    if (strlen( $dataProvider->job_title_img) > 0) {
                        $ar=explode( ';',$dataProvider->job_title_img);
                        $temp='';
                        foreach ($ar as $key => $value) {

                            $temp.= Html::img(\yii::$app->params['imgcdn'].$value, 
                                ['width'=>'30px',
                                'class'=>'td_img',
                                'data-d1'=>$dataProvider->hospital->name,
                                'data-d2'=>$dataProvider->department->name,
                                'data-d3'=>$dataProvider->jobtitle->name,
                                'data-d4'=>'job',
                                'data-toggle'=>"modal", 
                                'data-target'=>"#myModal",
                                ]);
                        }
                        return $temp;
                    }else{
                        return '';
                    }
                },
                 'format'=>'raw',
                
            ],
            // 'priority',
            // 'created_at',
            // 'updated_at',
            [ 'attribute'=>'updated_at',
                // 'label'=>'展示结束',
                'format' =>['date','php:Y-m-d H:i:s'],
                'contentOptions'=>['style'=>'width:9%'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{verify}{reject}{his} ',
                'header' => '操作',
                'buttons' => [
                'verify' => function ($url, $model, $key) { 
                    return Html::a('审核', 
                        '#', 
                        ['class' => 'tn  btn-block btn-success btn-xs',
                        'title'=>'认证用户',
                        'data-id'=>$model->id,
                        'data-type'=>'verify',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#verifyModal",
                        ]); 

                    },
                'reject' => function ($url, $model, $key) { 
                    return Html::a('驳回', 
                        '#', 
                        ['class' => 'tn  btn-block btn-danger btn-xs',
                        'title'=>'驳回认证',
                        'data-id'=>$model->id,
                        'data-type'=>'reject',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#verifyModal",
                        ]); 
                    },
                'his' => function ($url, $model, $key) { 
                    return Html::a('流水', 
                        '#', 
                        ['class' => 'tn  btn-block btn-primary btn-xs',
                        'title'=>'认证操作记录',
                        'data-uid'=>$model->uid,
                        'data-type'=>'reject',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#hisModal",
                        ]);

                    },
                'visibleButtons'=>[
                    'verify'=>function ($model, $key, $index) {
                        //...coding                     
                        return $model->id_status === 0;
                        },
                ],
            ],
        ]],
    ]); ?>
</div>
<script type="text/javascript">
    
    $('#myModal').on('show.bs.modal', function (event) {
        
      var button = $(event.relatedTarget).parent(); // Button that triggered the modal
      // console.log(button);
      var imgs = button.find('img');
      // console.log(imgs);
      $.each(imgs,function(index,element){

        var imgstr="<img id='card";
        imgstr=imgstr+index +"' width='283' height='350' src='"+$(element).attr('src')+"' style='";
        if (index >0) {
            imgstr=imgstr+"display:none'/>";
        }else{
            imgstr=imgstr+"'/>";
        };
        $('#myModal #next_page').append(imgstr);
        $('#myModal #img-title').html($(element).data('title'));
        
        var d1 =$(element).data('d1');
        var d2 =$(element).data('d2');
        var d3 =$(element).data('d3');
        var d4 =$(element).data('d4');
        var mytitle="<div class='row'>";
        if (d4=='card') {
            mytitle +="<div class='col-lg-3'><b>姓名：</b><span>"+d1+"</span></div>";
            mytitle +="<div class='col-lg-3'><b>证件类型：</b><span>"+d2+"</span></div>";
            mytitle +="<div class='col-lg-6'><b>证件号码：</b><span>"+d3+"</span></div>";
            mytitle +="</div>";
        }else{
            mytitle +="<div class='col-lg-6'><b>医院：</b><span>"+d1+"</span></div>";
            mytitle +="<div class='col-lg-3'><b>科室：</b><span>"+d2+"</span></div>";
            mytitle +="<div class='col-lg-3'><b>职称：</b><span>"+d3+"</span></div>";
            mytitle +="</div>";
        };
        $('#myModal #next_title').html(mytitle);
      });

    });
    $('#myModal').on('hidden.bs.modal', function (event) {
        // alert(2);
        $('#myModal #next_page').html('');
        $('#myModal #next_title').html('');
    });
    $('#round_image').click(function () {
        var angle=($('#myModal #round_image').data('angle')+90) %360;
        console.log(angle);
        rotate(angle);
        
    });
    $('#down_image').click(function () {
        rotate(0);
        var count =$('#myModal #next_page').children('img').size();
        var num=$('#myModal #down_image').data('num')+1;
        if (num >= count) {
            alert ('已经最后一张了！');
        }else{
            $('#myModal #next_page').children('img').hide();
            $('#myModal #down_image').data('num',num);
            $('#myModal #up_image').data('num',num);
            $('#myModal #next_page #card'+num).show();
        };
        
        
    });
    $('#up_image').click(function () {
        rotate(0);
        var count =$('#myModal #next_page').children('img').size();
        var num=$('#myModal #up_image').data('num');
        if (num <= 0) {
            alert ('已经第一张了！');
        }else{
            num =num-1;
            $('#myModal #next_page').children('img').hide();
            $('#myModal #up_image').data('num',num);
            $('#myModal #down_image').data('num',num);
            $('#myModal #next_page #card'+num).show();
        };
        
        
    });
    function rotate (angle) {
        
        $("#myModal #next_page").css({
            'transform':'rotate('+angle+'deg)',
            '-moz-transform':'rotate('+angle+'deg)',
            '-webkit-transform':'rotate('+angle+'deg)'
        });

        //ie下兼容
        var angle_num = angle/90;
        var iecss ='progid:DXImageTransform.Microsoft.BasicImage(rotation='+angle_num+')'
        $("#myModal #next_page").css('filter',iecss);
        $('#myModal #round_image').data('angle',angle);
    }


    $('#verifyModal').on('show.bs.modal', function (event) {
        var action = $(event.relatedTarget).data('type');
        console.log(action);
        var mytitle ='';
        if (action=='verify') {
            mytitle ="请填写认证理由:";
        }else{
            mytitle ="请填写驳回理由:";
        };
        $('#verifyModal .control-label').html(mytitle);
        $('#verifyModal #verified_reason').html('');
        $('#verifyModal .verify').attr('data-type',action);
        $('#verifyModal .verify').attr('data-id',$(event.relatedTarget).data('id'));
    });

    $('#verifyModal').on('hide.bs.modal', function (event) {
        // alert(2);
        $('#verifyModal .control-label').html('');
        $('#verifyModal #submitverify').attr('data-type','');
        $('#verifyModal .verify').attr('data-id','');
    });

    $('.verify').on('click', function() {
   
        var verified_reason = $('#verified_reason').val().trim(); 
        var id =$(this).data('id');
        var action=$(this).data('type');
        if (verified_reason=="") {
            $('#verified_reason').parent().addClass('has-error');
            $('#verified_reason').parent().next().html('必填');           
            return;
        }else{
            $('#verified_reason').parent().removeClass('has-error');
            $('#verified_reason').parent().next().html('');
        };
        var params ={id:id,action:action,reason:verified_reason};
        var msg ='';
        var actioncolor ='';
        if (action ='verify') {
            msg ='已审';
            actioncolor='#008d4c';
        }else{
            msg ='驳回';
            actioncolor='#000000';
        }; 

        $.ajax({
            url:'/backend/users-info/verify.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {
                alert(data.error);
                if (data.code==1) { 
                    console.log("1");
                    $('#status'+id).html(msg);
                    $('#status'+id).css('color',actioncolor);
                    $('#verifyModal').modal('hide'); 
                    $(".modal-backdrop").remove();                       
                }
            }
        }) 
        
    });

    $('#hisModal').on('show.bs.modal', function (event) {
        var uid = $(event.relatedTarget).data('uid');       
        var params ={uid:uid};
        var tclass=[{'tclass':"",'name':''},
                        {'tcolor':"#008d4c",'name':'认证'},
                        {'tcolor':"red",'name':'驳回'},];

        $.ajax({
            url:'/backend/users-info/verify-his.html',
            type:'POST',
            data:params,
            datatype:"json",
            success:function (data) {
                if (data.code==1) { 
                    if (data != "") {                        
                        for(var item in data.data){
                            var verified =data.data[item].verified;
                            var classobj = tclass[verified];
                            var temp=`<tr  >
                            <td>${getLocalTime(data.data[item].created_at)}</td>
                            <td>${data.data[item].uname}</td>
                            <td style="color:${classobj.tcolor}">${classobj.name}</td>
                            <td>${data.data[item].verified_reason}</td>
                            </tr>`;
                            $('#hisModal .his-body').append(temp);
                        } 
                    }                     
                }
                
            }
        }) 
    });

    $('#hisModal').on('hide.bs.modal', function (event) {
        // alert(2);
        $('#hisModal .his-body').html('');

    });

    /*
    *字符串替换，str 替换文本
    *replace 替换数组 key为被替换字符串 value替换为的内容{[key]}
    */
    function replace_str(str,replace) { 
      var words = str;
      for(var index in replace){
          var e=new RegExp('\\{\\['+String(index)+'\\]\\}',"g"); 
          words = words.replace(e, String(replace[index])); 
      }  
      return words; 
    }

    function getLocalTime(nS) { 
        var now =new Date(parseInt(nS) * 1000);
        var year =now.getFullYear();  
        var month=now.getMonth()+1;
        if (month < 10) {
            month=formatStr(month,2);
        }; 
        var date=now.getDate();
        if (date < 10) {
            date=formatStr(date,2);
        }; 
        var hour=now.getHours();
        if (hour < 10) {
            hour=formatStr(hour,2);
        };
        var minute=now.getMinutes(); 
        if (minute < 10) {
            minute=formatStr(minute,2);
        };
        var second=now.getSeconds();
        if (second < 10) {
            second=formatStr(second,2);
        }; 
         return year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second;   
    }

    function formatStr (str,len) {
        var strlen = String(str).length;
        if (strlen < len){
            for (var i = 0; i < len-strlen; i++) {
                str = "0"+str;
            };
        }
        return str;
    }

    

</script>
