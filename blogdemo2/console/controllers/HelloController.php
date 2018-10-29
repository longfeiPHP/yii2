<?php
namespace console\controllers;

use yii\console\Controller;
use common\models\Post;

class HelloController extends Controller
{
	public function actionIndex()
	{
		echo 'Hello World!';
	}
	public function actionList()
	{
		$post = Post::find()->all();
		foreach ($post as $aPost)
		{
			echo ($aPost['id']. " - ".$aPost['title'] ."\n");
		}
	}
	public function actionWho($name)
	{
		echo ("Hello ". $name . "!\n");
	}
}