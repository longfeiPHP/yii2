<?php
/**
 * Created by PhpStorm.
 * User: david
 */

namespace app\modules\backend\assets;
use yii\web\AssetBundle;

class AdminLtePluginsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/';
    public $js = [
        'plugins/slimScroll/jquery.slimscroll.min.js',
    ];
}