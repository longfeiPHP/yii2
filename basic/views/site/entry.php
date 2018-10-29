<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin();?>
	<?php echo $form->field($model, 'name')->label('用户名');?>
	<?php echo $form->field($model, 'email')->label('用户邮箱');?>
	
	<div class="form-group">
		<?php echo Html::submitButton('submit', ['class' => 'btn btn-primary']);?>
	</div>
<?php ActiveForm::end();?>