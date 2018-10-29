<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ShareInfo */

$this->title = '新建分享';
$this->params['breadcrumbs'][] = ['label' => '分享管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="share-info-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
