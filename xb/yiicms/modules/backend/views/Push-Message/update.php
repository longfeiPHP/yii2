<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PushMessage */

$this->title = 'Update Push Message: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Push Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="push-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
