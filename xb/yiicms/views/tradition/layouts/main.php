<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\widgets\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Carousel;
use yii\helpers\Url;

AppAsset::register($this)->css = [Yii::getAlias('/themes/tradition/css/site.css'),];
$carouselItems = [];
if (isset($this->params['adList'])) {
    foreach ($this->params['adList'] as $item) {
        $carouselItems[] = [
            'options'=>['style'=>'"background:url('.$item['image'].');background-size:cover;'],
            'content' => '<a href="' . $item['link'] . '" target="_black"><img src="' . $item['image'] . '" style="width:100%"/></a>',
//        'caption'=>'<h4>'.$item['title'].'</h4>',
        ];
    }
}
$brandLabel = Yii::$app->name;
if(!empty(Yii::$app->params['logo'])){
    $brandLabel = '<img src="'.Yii::getAlias(Yii::$app->params['logo']).'"/>';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) . '-' . Yii::$app->name ?></title>
    <?php $this->head() ?>
   
</head>
<body  class="skin-blue fixed">
<?php $this->beginBody() ?>
<div class="wrap">

    <div>
        <?php NavBar::begin([
            'brandLabel' => $brandLabel,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar  navbar-'. ArrayHelper::getValue($this->params, 'themeColor', 'blue'),
                'style'=>'height: 80px;',
            ],
        ]);
        // echo Nav::widget(\app\helpers\CommonHelper::navTranslation(json_decode(Yii::$app->params['nav'], true)));
        ?>
        <?php NavBar::end(); ?>
    </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">&copy; 问问科技 <?= date('Y') ?> 版权所有 侵权必究</div>
        </div>

    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
