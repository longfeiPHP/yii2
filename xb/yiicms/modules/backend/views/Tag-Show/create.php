<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TagShow */

$this->title = '指派标签';
$this->params['breadcrumbs'][] = ['label' => '展示管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-show-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
