<?php
/** @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '用户信息';
?>
<div class="backend-default-index ">
    <div class="row">
        <div class="col-md-12 index_info">
            <div class="index_left" ><i class="fa fa-user" aria-hidden="true"></i></div>
            <div class="index_right col-md-11 text-left " >
                <div class="col-md-3">
                    <span>帐号：</span>
                    <span><?=isset(Yii::$app->user->identity->username)? ' '.Yii::$app->user->identity->username:''?></span>
                </div>
                <div class="col-md-6">
                    <span>手机号：</span>
                    <span><?=isset(Yii::$app->user->identity->email)? ' '.Yii::$app->user->identity->email:''?></span>
                </div>

            </div>
        </div>
    </div>
</div>
