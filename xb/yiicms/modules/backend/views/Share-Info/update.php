<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShareInfo */

$this->title = 'Update Share Info: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '分享文案列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="share-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
