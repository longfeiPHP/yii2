<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UsersInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'uid',
            'sid',
            'mobile',
            'realname',
            'stype',
            'id_status',
            'id_card_type',
            'id_card_no',
            'id_card_img',
            'id_card_bg_img',
            'id_card_usr_img',
            'real_card_img',
            'hospital_id',
            'department_id',
            'jobtitle_id',
            'reg_cert_img',
            'job_title_img',
            'priority',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
