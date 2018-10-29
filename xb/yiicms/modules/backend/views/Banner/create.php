<?php

use yii\helpers\Html;
use app\models\Banner;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
$type_name = Banner::getBannerType()[$banner_type];
$this->title = '创建'.$type_name;
$this->params['breadcrumbs'][] = ['label' => $type_name.'管理', 'url' => ['index?banner_type='.$banner_type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'banner_type'=>$banner_type,
    ]) ?>

</div>


