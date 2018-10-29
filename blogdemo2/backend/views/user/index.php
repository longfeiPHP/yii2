<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
//             'auth_key',
//             'password_hash',
//             'password_reset_token',
            'email:email',
            //'status',
            [
            	'attribute' => 'status',
            	'value' => 'statusStr'
            ],
            //'created_at',
            [
            	'attribute' => 'created_at',
            	'value' => function ($model)
            	{
            		return date('Y-m-d H:i:s', $model->created_at);
            	}
            ],
            //'updated_at',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
