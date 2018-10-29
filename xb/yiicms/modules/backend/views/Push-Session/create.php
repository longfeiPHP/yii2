<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PushSession */

$this->title = '创建类型';
$this->params['breadcrumbs'][] = ['label' => '推送类型列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="push-session-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
