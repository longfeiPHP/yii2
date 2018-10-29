<?php

namespace app\controllers;

use Yii;
// use app\components\AppController as Controller;
use app\components\RedisKey;
use yii\web\Controller;
use app\models\News;
use app\components\qywx\QYWX;
use app\components\qywx\log;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    // public $layout = "";
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $products = Products::find()->where(['status'=>Products::STATUS_ENABLE])->orderBy('id desc')->limit(12)->all();
        // $aboutUs = Config::find()->where(['name'=>'about_us'])->one();
        // return $this->render('index', [
        //     'aboutUs'=>$aboutUs,
        //     'products' => $products,
        // ]);
        $this->redirect(array('/backend'));
        // $this->layout('none');
        return;
    }

    public function actionLevel()
    {
        // $products = Products::find()->where(['status'=>Products::STATUS_ENABLE])->orderBy('id desc')->limit(12)->all();
        // $aboutUs = Config::find()->where(['name'=>'about_us'])->one();
        // return $this->render('index', [
        //     'aboutUs'=>$aboutUs,
        //     'products' => $products,
        // ]);
        $this->layout = 'empty';
        $redis = \Yii::$app->redis;
        $atricleId = \Yii::$app->params['level']['Id'];
        $expire_time = \Yii::$app->params['level']['expire_time'];
        $RedisKey =RedisKey::levelKey($atricleId);
        $contents = $redis->get($RedisKey);
        $data =[];
        if (empty($content)) {
            // $models=\app\models\Content::find()->joinWith('detail')->where(['id'=>$atricleId])->asArray()->one();
            $models=\app\models\News::findOne($atricleId);
            // var_dump($models->detail->detail);return;
            if (empty($models)) {
                $data =[
                    'content' =>"",
                    'title' =>""
                ];               
            }else{
                $data =[
                    'content' =>$models->detail->detail,
                    'title' =>$models->title
                ];
                // $redis->set($RedisKey,json_encode($data));
                $redis->SETEX($RedisKey,$expire_time,json_encode($data));

            }
        }else{
            $data = json_decode($contents,true);
        }
        return $this->render('mobile_page', $data);

    }


    public function actionSendWxText()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $params =\Yii::$app->request->post();
        $QYWX = new QYWX();
        /**/
        $sign =\Yii::$app->request->post('sign','');
        $key = \Yii::$app->params['qywx_sign_key'];
        unset($params['sign']);
        if (!$QYWX->checkSign($key,$sign,$params)){
            echo(json_encode(['code'=>1,'msg'=>'sign error']));
            $log = new log();
            $log->writelog("signError: ".var_export($Params,true),'qywx');
            return;
        }

        
        $to=\Yii::$app->request->post('to','');
        $toType=\Yii::$app->request->post('totype','');
        $content=\Yii::$app->request->post('content','');
        $res = $QYWX->sendText($to,$toType,$content);
        if ($res['result']) {
            echo(json_encode(['code'=>0,'msg'=>'success']));
        }else{
            echo(json_encode(['code'=>1,'msg'=>'WXservers return error!'.$res['msg']])); 
        }
        // var_dump($res) ;
        return;

    }

    public function actionSign()
    {
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $params =\Yii::$app->request->get();
        $QYWX = new QYWX();
        /**/
        $sign =\Yii::$app->request->get('sign','');
        $key = \Yii::$app->params['qywx_sign_key'];
        $params['time']=time();
        unset($params['sign']);
        $sign=$QYWX->makeSign($key,$params);
        $rs='sign='.$sign;
        foreach ($params as $key => $value) {
            $rs .='&'.$key.'='.$value;
        }
        echo $rs;return;

    }

    /**
     * 修改语言
     * @param string $language
     * @return string
     */
    public function actionLanguage($language)
    {
        Yii::$app->session->set('language', $language);
        $referrer = Yii::$app->request->getReferrer();
        return $this->redirect($referrer?$referrer:Yii::$app->getHomeUrl());
    }
    
    public function actionRedisTest()
    {
        
        $this->layout = 'empty';
        $redis = \Yii::$app->redis;
        
        $redis->set('k','v');
        echo $redis->get('k');
        return;
    }
}
