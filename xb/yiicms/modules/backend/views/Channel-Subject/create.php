<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ChannelSubject */

$this->title = '新建频道';
$this->params['breadcrumbs'][] = ['label' => '频道列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-subject-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
