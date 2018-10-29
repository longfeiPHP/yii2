<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Adminuser;

$model = Adminuser::findOne($id);
$this->title = '权限设置: '.$model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="adminuser-update">
	<h1><?php echo Html::encode($this->title);?></h1>
	<div class="adminuser-privilege-form">
		<?php $form = ActiveForm::begin();?>
		<?php echo Html::checkboxList('newPri', $AuthAssignmentsArray, $allPrivilegesArray);?>
		<div class="form-group">
			<?= Html::submitButton('设置') ?>
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>