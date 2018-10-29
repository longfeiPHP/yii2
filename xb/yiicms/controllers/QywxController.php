<?php

namespace app\controllers;

use Yii;
// use app\components\AppController as Controller;
use app\components\RedisKey;
use app\components\qywx\QYWX;
use app\components\qywx\log;
use app\components\ApiController;
use app\components\Response;

class QywxController extends ApiController
{


    public function init()
    {
        parent::init();
        //绑定beforeSend事件，更改数据输出格式
        //Yii::$app->getResponse()->on(Response::EVENT_BEFORE_SEND, [$this, 'beforeSend']);
    }


    public function actionSendWxText()
    {
        $params =\Yii::$app->request->post();
        $QYWX = new QYWX();
        /**/
        $sign =\Yii::$app->request->post('sign','');
        $key = \Yii::$app->params['qywx_sign_key'];
        unset($params['sign']);
        if (!$QYWX->checkSign($key,$sign,$params)){
            // echo(json_encode(['code'=>1,'msg'=>'sign error']));
            $log = new log();
            $log->writelog("signError: ".var_export($params,true),'qywx');
            self::sendWaring('sign error!');
            Response::show(401,'sign error!');
        }

        
        $to=\Yii::$app->request->post('to','');
        $toType=\Yii::$app->request->post('totype','');
        $content=\Yii::$app->request->post('content','');
        $content = str_replace(array('\n'), "\n", $content);  
        $res = $QYWX->sendText($to,$toType,$content);
        if ($res['result']) {
            Response::show(200,'success');
        }else{
            Response::show(400,'WXservers return error!'.$res['msg']);
        }
        // var_dump($res) ;
        // return;

    }


    public static function sendWaring($msg)
    {
        $to='lixiaobo';
        $toType='user';
        $content=date('Y-m-d h:i:s')."发生异常：\n".$msg;
        $res = $QYWX->sendText($to,$toType,$content);
        return true;
    }

    public function actionSendErrorText()
    {
        $params =\Yii::$app->request->post();
        $QYWX = new QYWX();
        /**/
        $sign =\Yii::$app->request->post('sign','');
        $key = \Yii::$app->params['qywx_sign_key'];
        unset($params['sign']);
        if (!$QYWX->checkSign($key,$sign,$params)){
            // echo(json_encode(['code'=>1,'msg'=>'sign error']));
            $log = new log();
            $log->writelog("signError: ".var_export($params,true),'qywx');
            Response::show(401,'sign error!');
        }

        
        $to='001';
        $toType='tag';
        $content=\Yii::$app->request->post('content','');
        $content = str_replace(array('\n'), "\n", $content);  
        $res = $QYWX->sendText($to,$toType,$content);
        if ($res['result']) {
            Response::show(200,'success');
        }else{
            Response::show(400,'WXservers return error!'.$res['msg']);
        }
        // var_dump($res) ;
        // return;

    }

    public function actionSign()
    {
        
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

    public function actionSendtest()
    {
        
        $QYWX = new QYWX();
        /**/
        $key = \Yii::$app->params['qywx_sign_key'];
        $to ='lixiaobo';
        $totype='user';
        $content="test\n我的生活\n第三行";
        $res = $QYWX->sendText($to,$totype,$content);
        if ($res['result']) {
            // echo(json_encode(['code'=>0,'msg'=>'success']));
            Response::show(200,'success');
        }else{
            // echo(json_encode(['code'=>1,'msg'=>'WXservers return error!'.$res['msg']])); 
            Response::show(400,'WXservers return error!'.$res['msg']);
        }

    }

}
