<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户信息';
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
            <h4 class="modal-title">身份照片</h4>
            姓名：<span id="img-realname"></span>
            身份证号：<span id="img-id_card_no"></span>
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

<div class="user-index">

    
     <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<!-- 
    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         // 'filterModel' => $searchModel,
         'options'=>['class' => 'panel panel-default'],
         'headerRowOptions' => ['class' => 'active','style'=>''], 
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => CheckboxColumn::className()],
            'id',
            // 'uid',
            // 'gender',
            ['attribute'=>'uid',
            'label'=>'uid',
            'value'=>function($dataProvider){
                return '...'.mb_substr( $dataProvider->uid, -5, 5,'UTF-8' )  ;
            },
            'format'=>'raw',
            'contentOptions'=>
                function ($dataProvider)
                {
                    return [
                        'width'=>'10%',
                        'title' =>$dataProvider->uid,
                    ];
                },
            
            ],
            'sid',
            'mobile',
            // 'third_type',
            // 'third_account',
            // 'unionid',
            // 'mpopenid',
            // 'nickname',
            // 'realname',
            // 'gender',
            ['attribute'=>'gender',
            'label'=>'性别',
            'contentOptions'=>['width'=>'5%'],
            'value'=>function ($dataProvider)
            {
                return strtolower($dataProvider->gender) =='f'?  '女':'男';
            }],
            // 'level',
            // 'star_level',
            // 'birthday',
            // 'blood_type',
            // 'interest',
            // 'job',
            // 'id_card_type',
            // 'id_card_no',
            // 'id_card_image',
            ['attribute'=>'id_card_image',
                'label'=>'身份证图',
                'contentOptions'=>[],
                'value'=>function ($dataProvider)
                {
                    
                    if (strlen( $dataProvider->id_card_image) > 0) {
                        $ar=explode( ';',$dataProvider->id_card_image);
                        $temp='';
                        foreach ($ar as $key => $value) {

                            $temp.= Html::img('http://xdjtest.oss-cn-beijing.aliyuncs.com/'.$value, 
                                ['width'=>'30px',
                                'class'=>'img',
                                'data-realname'=>$dataProvider->realname,
                                'data-idcardno'=>$dataProvider->id_card_no,
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
            // 'organization_id',
            // 'nanny_id',
            // 'avatar',
            ['attribute'=>'avatar',
            'label'=>'头像',
            'format' => [
                'image', 
                [
                'width'=>'30',
                'height'=>'30',
                'class'=>'ab'
                ]
            ],

            'value'=>function ($dataProvider)
            {
                return 'http://xdjtest.oss-cn-beijing.aliyuncs.com/' .$dataProvider->avatar;
            }],
            // 'slogan',
            // 'id_status',
            // 'verified',
            // 'verified_reason',
            // 'province',
            // 'city',
            // 'district',
            // 'new_pop_url:url',
            // 'is_share_sm',
            // 's_status',
            // 'is_fill_information',
            // 'is_zombie',
            // 'wechat_info',
            // 'shut_up_count',
            // 'weight',
            // 'temp',
            // 'is_star',
            // 'is_activity',
            // 'state',
            // 'created',
            // 'updated',
            // 'online_state',
            // 'is_fraud',
            // 's_type',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{get-xxx} {view} {update}',
                'header' => '操作',
                'buttons' => [
                'get-xxx' => function ($url, $model, $key) { 
                    return Html::a('Create User', 
                        ['create'], 
                        ['class' => 'btn btn-success',
                        'title'=>'Create User',
                        'data-toggle'=>"modal", 
                        'data-target'=>"#myModal",
                        // 'data' => [
                        //     'confirm' => '你确定要删除此记录吗?',
                        //     'method' => 'post',
                        // ],


                        ]

                         ); 
                    },
                ],

            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function (event) {
        
      var button = $(event.relatedTarget).parent(); // Button that triggered the modal
      // console.log(button);
      var imgs = button.find('img');
      // console.log(imgs);
      $.each(imgs,function(index,element){
        // alert($(this).text())
        var imgstr="<img id='card";
        imgstr=imgstr+index +"' width='283' height='350' src='"+$(element).attr('src')+"' style='";
        if (index >0) {
            imgstr=imgstr+"display:none'/>";
        }else{
            imgstr=imgstr+"'/>";
        };
        $('#myModal #next_page').append(imgstr);
        $('#myModal #img-realname').html($(element).data('realname'));
        $('#myModal #img-id_card_no').html($(element).data('idcardno'));
        // $('#myModal #card'+index).attr('src',$(element).attr('src'));
      });
      // var recipient = button.data('whatever') // Extract info from data-* attributes
      // // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      // var modal = $(this)
      // modal.find('.modal-title').text('New message to ' + recipient)
      // modal.find('.modal-body input').val(recipient)
    });
    $('#myModal').on('hidden.bs.modal', function (event) {
        // alert(2);
        $('#myModal #next_page').html('');
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

</script>
