<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath ='@app/modules/backend/assets/';
    public $baseUrl = '@web';
    public $css = [
//        'backend.css',
    ];
    public $js = [
        'skin.js',
        'backend.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'dmstr\web\AdminLteAsset',
//        'mdm\admin\AutocompleteAsset',
        'app\modules\backend\assets\AdminLtePluginsAsset',
    ];

    //定义按需加载JS方法，注意加载顺序在最后  
    public static function addScript($view, $jsfile) {  
        $view->registerJsFile($jsfile, [BackendAsset::className(), 'depends' => 'app\modules\backend\assets\BackendAsset']);  
    }  
      
   //定义按需加载css方法，注意加载顺序在最后  
    public static function addCss($view, $cssfile) {  
        $view->registerCssFile($cssfile, [BackendAsset::className(), 'depends' => 'app\modules\backend\assets\BackendAsset']);  
    } 
}
