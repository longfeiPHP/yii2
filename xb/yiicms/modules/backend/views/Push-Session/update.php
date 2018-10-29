<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PushSession */

$this->title = '更新推送类型 ID: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '推送类型列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="push-session-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
