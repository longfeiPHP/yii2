<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PushMessage */

$this->title = '创建推送消息';
$this->params['breadcrumbs'][] = ['label' => '推送消息列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="push-message-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
