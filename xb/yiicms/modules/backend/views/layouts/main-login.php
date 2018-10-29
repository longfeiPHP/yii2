<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\modules\backend\assets\BackendAsset;

BackendAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" style="height=100%">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            .site-login{
                background: rgba(255,255,255,.3);
                padding: 45px;
                padding-top: 20px;
                border-radius: 10px;
                -webkit-border-radius: 10px;
                position: relative;
            }
            .login-box-body{
                background: none;
                color: #fff; 
            }
            .login-logo img{
                width: 50%;
            }
        </style>
    </head>
    <body class="login-page" style="background: url(/../images/bk.jpg) no-repeat scroll 0 0 / cover;">
    <?php $this->beginBody() ?>

    <div class="wrap">
        <div class="container">
            <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>