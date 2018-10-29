<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php echo Html::a('百度','http://www.baidu.com');?>
<?php echo Html::beginForm('sd','POST');?>
<?php echo Html::endForm();?>
<?php echo Html::beginTag('a',['class'=>'aa']);?>
xxx
<?php echo Html::endTag('a');?>
<?php echo Url::home();?>
<?php echo Url::base();?>
<br />
<?php echo Url::toRoute(['product/view', 'id' => 42]);?>
<?php echo Url::current();?>