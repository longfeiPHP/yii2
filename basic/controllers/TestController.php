<?php

namespace app\controllers;

use app\core\front\FrontController;

class TestController extends FrontController
{
	public function actionIndex(){
		
		return $this->render('index');
	}
}