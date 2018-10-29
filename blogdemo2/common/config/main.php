<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
//             'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
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
    	'redis' => [
    		'class' => 'yii\redis\Connection',
    		'hostname' => 'localhost',
    		'port' => 6379,
    		'database' => 0,
    	],
    ],
];
