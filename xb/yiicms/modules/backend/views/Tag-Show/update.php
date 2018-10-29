<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TagShow */

$this->title = 'Update Tag Show: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tag Shows', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tag-show-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
