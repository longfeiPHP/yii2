<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TagList */

$this->title = '创建标签';
$this->params['breadcrumbs'][] = ['label' => '标签列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-list-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
