<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

	<?php 
// 		$psObjs = Poststatus::find()->all();
// 		$allStatus = ArrayHelper::map($psObjs, 'id', 'name');

// 		$psObjs = Yii::$app->db->createCommand("select * from poststatus")->queryAll();
// 		$allStatus = ArrayHelper::map($psObjs, 'id', 'name');

// 		$allStatus = (new \yii\db\Query())
// 		->select(['name', 'id'])
// 		->from('poststatus')
// 		->indexBy(id)
// 		->column();	

		$allStatus = Poststatus::find()
		->select(['name', 'id'])
		->indexBy(id)
		->column();
		
		$allUser = (new \yii\db\Query())
		->select(['nickname', 'id'])
		->from('adminuser')
		->indexBy(id)
		->column();
	?>    
    <?= $form->field($model, 'status')->dropDownList($allStatus,['prompt'=>'请选择状态']);?>

    

    <?= $form->field($model, 'author_id')->dropDownList($allUser,['prompt'=>'请选择作者']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
