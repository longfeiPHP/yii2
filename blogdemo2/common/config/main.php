<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    	'authManager' => [
    		'class' => 'yii\rbac\DbManager'
    	],
    	'assetManager'=>[
    		'bundles'=>[
    			'yii\web\JqueryAsset'=>[
    				'jsOptions'=>[
    					'position'=>\yii\web\View::POS_HEAD,
    				]
    			]
    		]
    	],
    ],
];
