<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #62a8ea;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">图片预览</h4>
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
<script type="text/javascript">
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

    $('#myModal').on('show.bs.modal', function (event) {
        
      var button = $(event.relatedTarget).parent(); // Button that triggered the modal
      // console.log(button);
      var imgs = button.find('img');
      // console.log(imgs);
      $.each(imgs,function(index,element){

        var imgstr="<img id='card";
        imgstr=imgstr+index +"' width='' height='350' src='"+$(element).attr('src')+"' style='";
        if (index >0) {
            imgstr=imgstr+"display:none'/>";
        }else{
            imgstr=imgstr+"'/>";
        };
        $('#myModal #next_page').append(imgstr);
        $('#myModal #img-title').html($(element).data('title'));

      });

    });
    $('#myModal').on('hidden.bs.modal', function (event) {
        // alert(2);
        $('#myModal #next_page').html('');
    });
</script>