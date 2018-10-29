<?php
use app\components\LinkPager;
use yii\helpers\Html;

$this->title = '短信验证码';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="search">
        <div class="group clearfix">
            <div class="search-group">
                <label>
                    <span>手机号</span>
                    <input type="text" name="mobile" id="mobile" value="" />
                </label>
                <button type="button" class="btn btn-group btn-primary" onclick='searchCode()'>搜索</button>
            </div>
        </div>
        <div class="group clearfix">

        </div>
</div>

<script type="text/javascript">
    function searchCode()
    {
        var mobile = $('#mobile').val();
        if(mobile == ''){
            alert('手机号不能为空');
            return false;
        }
        $.post("/backend/user/search-code.html", {mobile: mobile},
            function(data){
                // var dat = eval('('+data+')');
                if(data.code == '0'){
                    alert(data.error);
                }else{
                    alert('验证码'+data.data.value+',剩余有效时长'+data.data.expire+'s');
                }
            });
    }
</script>
