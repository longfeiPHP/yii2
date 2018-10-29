<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Baidu.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file components/Getui.php
 * @author zhongligang01(zhongligang01@baidu.com)
 * @date 2015-06-22 20:55:30
 * @brief
 *
 **/

namespace app\modules\backend\components;

use Yii;
use yii\helpers\ArrayHelper;

class Getui {
    private $arrConf;
    const  item = 800;
    const  limit = 20;

    public function __construct() {
        $strRoot = dirname(__FILE__) . '/getui';
        require_once($strRoot . '/IGt.Push.php');
        require_once($strRoot . '/igetui/IGt.AppMessage.php');
        require_once($strRoot . '/igetui/IGt.APNPayload.php');
        require_once($strRoot . '/igetui/template/IGt.BaseTemplate.php');
        require_once($strRoot . '/IGt.Batch.php');

        \LogUtils::$debug = false;
    }

    /**
     * 发送单条推送
     * @param $cids 个推CID数组
     * @param $strType 消息大类别（IM消息、支付通知）
     * @param $strTitle 标题
     * @param $strContent 内容
     * @param $arrData 透传数据
     * @param $toSm true:发给超人 false:发给买家
     * @param $badge  应用icon上显示的数字
     * @param $arrPayload 通知内容
     * @param $seconds 作为在线和离线的标志位
     * @return bool true:发送成功 false:发送失败
     */
    public function pushMessageToList($cids, $strType = null, $strTitle = null, $strContent = null,
        $arrData = null, $toSm = false, $badge = 0, $arrPayload = null, $seconds = 0)
    {
        try
        {
            $objTemplate = $this->XDJMessageTemplete($strType, $strTitle, $strContent, $arrData, $toSm, $badge,
                $arrPayload, $seconds);
            $igt = new \IGeTui($this->arrConf['host'], $this->arrConf['appkey'], $this->arrConf['mastersec']);
            $message = new \IGtListMessage();

            if($seconds > 0 ){
                $message->set_isOffline(false);
            } else {
                $message->set_isOffline(true);
                $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
            }

            $message->set_data($objTemplate);//设置推送消息类型
            //$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
            $contentId = $igt->getContentId($message,'toList');
            //$contentId = $igt->getContentId($message,"toList任务别名功能");	//根据TaskId设置组名，支持下划线，中文，英文，数字
            $targetList = [];
            foreach($cids as $cid)
            {
                $target = new \IGtTarget();
                $target->set_appId($this->arrConf['appid']);
                $target->set_clientId($cid);
                //$target1->set_alias(ALIAS);
                $targetList[] = $target;
            }
            // \app\components\Tool::commandLog('Getui.log', $strTitle);
            // \app\components\Tool::commandLog('Getui.log', $strContent);
            // \app\components\Tool::commandLog('Getui.log', json_encode($arrData));
            // \app\components\Tool::commandLog('Getui.log', "Content Id : ".$contentId);
            $this->writeTaskIdToFile($contentId, $arrData,'list');
            $this->writeTaskIdToFile($contentId, $cids, 'list');
            $arrResponse = $igt->pushMessageToList($contentId, $targetList);
            $this->writeTaskIdToFile($contentId, $arrResponse, 'list');
            // \app\components\Tool::commandLog('Getui.log', json_encode($arrResponse));
            if (!is_array($arrResponse) || empty($arrResponse['result']) || $arrResponse['result'] !== 'ok') {
                //Yii::warning(json_encode($arrResponse), __METHOD__);
                return false;
            }
            return true;
        }
        catch (\Exception $e)
        {
            \app\components\Tool::commandLog('Getui.log', $e->getFile().$e->getLine().$e->getMessage());
        }
        return false;

    }


    function SendToApp($notity_title,$notity_content,$im_content,$logo_url){
        //$igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
        // $this->init();
        $template = $this->InitNotificationTemplate($notity_title,$notity_content,$im_content,$logo_url);
        \Yii::info($this->arrConf);
        $igt = new \IGeTui($this->arrConf['host'],$this->arrConf['appkey'],$this->arrConf['mastersec'],false);

        //消息模版：
        // 1.TransmissionTemplate:透传功能模板
        // 2.LinkTemplate:通知打开链接功能模板
        // 3.NotificationTemplate：通知透传功能模板
        // 4.NotyPopLoadTemplate：通知弹框下载功能模板

    //      $template = IGtNotyPopLoadTemplateDemo();
    //      $template = IGtLinkTemplateDemo();

       
        // $template = IGtTransmissionTemplateDemo();

        //个推信息体
        $message = new \IGtAppMessage();

        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600*12*1000);//离线时间
        $message->set_data($template);//设置推送消息类型
        $appIdList=array($this->arrConf['appid']);
        $message->set_appIdList($appIdList);


        try {
            // $rep = $igt->pushMessageToSingle($message, $target);
            $rep = $igt->pushMessageToApp($message,"任务组名");
            return $rep;
            var_dump($rep);
            echo ("<br><br>");

        }catch(RequestException $e){
            return $e;
            var_dump($e);
            echo ("<br><br>");
        }

    }

    public function PushMessageToApp($strType = null, $strTitle = null, $strContent = null,
        $arrData = null, $toSm = false, $badge = 0, $arrPayload = null, $seconds = 0)
    {
        try {
            $template = $this->XDJMessageTemplete($strType, $strTitle, $strContent,
                $arrData, $toSm, $badge, $arrPayload, $seconds);
            $igt = new \IGeTui($this->arrConf['host'], $this->arrConf['appkey'], $this->arrConf['mastersec']);
            $message = new \IGtAppMessage();
            $message->set_isOffline(true);
            $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
            $message->set_data($template);
            $message->set_PushNetWorkType(1);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
            //$message->set_speed(1000);// 设置群推接口的推送速度，单位为条/秒，例如填写100，则为100条/秒。仅对指定应用群推接口有效。
            $message->set_appIdList(array($this->arrConf['appid']));
            $message->set_phoneTypeList(array('ANDROID'));
            $arrResponse = $igt->pushMessageToApp($message);

            if (!is_array($arrResponse) || empty($arrResponse['result']) || $arrResponse['result'] !== 'ok') {
                return false;
            }
            return true;
        }  catch (\Exception $e) {
            \app\components\Tool::commandLog('Getui.log', $e->getFile().$e->getLine().$e->getMessage());
        }
        return false;
    }
    /**
     * 发送单条推送
     * @param $strCid 个推CID
     * @param $strType 消息大类别（IM消息、支付通知）
     * @param $strTitle 标题
     * @param $strContent 内容
     * @param $arrData 透传数据
     * @param $toSm true:发给超人 false:发给买家
     * @param $badge 应用icon上显示的数字
     * @param $arrPayload
     * @param $seconds 离线时间
     * @return bool true:发送成功 false:发送失败
     */
    public function pushMessageToSingle($strCid, $strType = null, $strTitle = null, $strContent = null,
        $arrData = null, $toSm = false, $badge = 0, $arrPayload = null, $seconds = 0)
    {
        try {
            $objTemplate = $this->XDJMessageTemplete($strType, $strTitle, $strContent,
                $arrData, $toSm, $badge, $arrPayload, $seconds);
            $objMsg = new \IGtSingleMessage();
            $objMsg->set_data($objTemplate); //设置推送消息类型

            if($seconds > 0) {
                //直播间使用
                $objMsg->set_isOffline(false);
            } else {
                $objMsg->set_isOffline(true); //是否离线
                $objMsg->set_offlineExpireTime(3600 * 12 * 1000); //离线时间
            }

            $objTarget = new \IGtTarget();
            $objTarget->set_appId($this->arrConf['appid']);
            $objTarget->set_clientId($strCid);

            $objIgt = new \IGeTui($this->arrConf['host'], $this->arrConf['appkey'], $this->arrConf['mastersec']);
            $contentId = '';
            $this->writeTaskIdToFile($contentId, $arrData,'single');
            $this->writeTaskIdToFile($contentId, $strCid, 'single');
            //try {
            $arrResponse = $objIgt->pushMessageToSingle($objMsg, $objTarget);
            // } catch (\RequestException $e){
            //    $intRequstId = $e->getRequestId();
            //   $arrResponse = $objIgt->pushMessageToSingle($objMsg, $objTarget,$intRequstId);
            //}
            $this->writeTaskIdToFile($contentId, $arrResponse, 'single');
            if (!is_array($arrResponse) || empty($arrResponse['result']) || $arrResponse['result'] !== 'ok') {
                //Yii::warning(json_encode($arrResponse), __METHOD__);
                return false;
            }

            return true;
        }
        catch (\Exception $e)
        {
            \app\components\Tool::commandLog('Getui.log', $e->getFile().$e->getLine().$e->getMessage());
        }
        return false;
    }

    function InitNotificationTemplate($notity_title,$notity_content,$im_content,$logo_url){
        $this->arrConf = Yii::$app->params['getui']['ww'];
        $template =  new \IGtNotificationTemplate();
        $template->set_appId($this->arrConf['appid']);                   //应用appid
        $template->set_appkey($this->arrConf['appkey']);                 //应用appkey
        $template->set_transmissionType(1);            //透传消息类型
        $template->set_transmissionContent($im_content);//透传内容
        $template->set_title($notity_title);                  //通知栏标题
        $template->set_text($notity_content);     //通知栏内容
        $template->set_logo($logo_url);                       //通知栏logo
        $template->set_logoURL($logo_url);                    //通知栏logo链接
        $template->set_isRing(true);                   //是否响铃
        $template->set_isVibrate(true);                //是否震动
        $template->set_isClearable(true);              //通知栏是否可清除

        return $template;
    }

    private function XDJMessageTemplete($strType = null, $strTitle = null, $strContent = null,
        $arrData = null, $toSm = false, $badge = 0, $arrPayload = null, $seconds = 0)
    {
        // if ($toSm == true)
        // {
        //     $this->arrConf = Yii::$app->params['getui']['ww'];
        // }
        // else
        // {
        //     $this->arrConf = Yii::$app->params['getui']['xiandanjia'];
        // }

        $this->arrConf = Yii::$app->params['getui']['ww'];

        if ($arrData === null)
        {
            $arrData = [
                'type' => '',
                'title' => '问问',
                'content' => '',
            ];
        }

        // type通过透传发送
        if ($strType !== null)
        {
            $arrData['type'] = $strType;
        }
        // title通过透传发送
        if ($strTitle !== null)
        {
            $arrData['title'] = $strTitle;
        }
        // content通过透传发送
        if ($strContent !== null)
        {
            $arrData['content'] = $strContent;
        }
        else
        {
            $arrData['content'] = '';
        }

        // 防止超出APNs数据限制
        if (!empty($arrData['title']) && mb_strlen($arrData['title'], 'UTF-8') > 10)
        {
            $arrData['title'] = mb_substr($arrData['title'], 0, 10, 'UTF-8');
        }
        if (!empty($arrData['content']) && mb_strlen($arrData['content'], 'UTF-8') > 30)
        {
            $arrData['content'] = mb_substr($arrData['content'], 0, 30, 'UTF-8').'...';
        }

        $objTemplate = new \IGtTransmissionTemplate();
        $objTemplate->set_appId($this->arrConf['appid']); //应用appid
        $objTemplate->set_appkey($this->arrConf['appkey']); //应用appkey
        $objTemplate->set_transmissionType(2); //是否立即启动，1:启动，2:客户自启动
        $objTemplate->set_transmissionContent(json_encode($arrData)); //透传内容
        if($seconds)
        {
            $begin = date('Y-m-d H:i:s');
            $end = date('Y-m-d H:i:s',time()+$seconds);
            $objTemplate->set_duration($begin,$end);
        }

        // APNs推送
        if ($strContent !== null) {
            $alertmsg = new \DictionaryAlertMsg();
            $alertmsg->body         = $arrData['content']; //通知文本消息字符串
            // $alertmsg->actionLocKey = "ActionLockey"; //(用于多语言支持）指定执行按钮所使用的Localizable.strings
            // $alertmsg->locKey       = "LocKey"; //(用于多语言支持）指定Localizable.strings文件中相应的key
            // $alertmsg->locArgs      = array("locargs"); //如果loc-key中使用的占位符，则在loc-args中指定各参数
            // $alertmsg->launchImage  = "launchimage"; //指定启动界面图片名
            // iOS8.2 支持
            $alertmsg->title        = $arrData['title']; //通知标题
            // $alertmsg->titleLocKey  = "TitleLocKey"; //(用于多语言支持）对于标题指定执行按钮所使用的Localizable.strings
            // $alertmsg->titleLocArgs = array("TitleLocArg"); //对于标题, 如果loc-key中使用的占位符，则在loc-args中指定各参数

            $apn = new \IGtAPNPayload();
            $apn->alertMsg = $alertmsg;
            $apn->badge    = $badge; //应用icon上显示的数字
            $apn->sound    = ''; //通知铃声文件名
            if ($arrPayload != null) {
                $apn->add_customMsg('payload', json_encode($arrPayload)); //增加自定义的数据
            }
            // $apn->contentAvailable=1; //推送直接带有透传数据
            // $apn->category="ACTIONABLE"; //在客户端通知栏触发特定的action和button显示
            $objTemplate->set_apnInfo($apn);
        }
        return $objTemplate;
    }

    /**
     * 根据$cids 数量分批发送
     * @param $cids
     * @param null $strType
     * @param null $strTitle
     * @param null $strContent
     * @param null $arrData
     * @param bool $toSm
     * @param int $badge
     * @param array $arrPayload
     * @param bool $isLive 群推时候是不是直播间
     * @return bool true:发送成功 false:发送失败
     */
    public function pushMessageToListByCids($cids, $strType = null, $strTitle = null, $strContent = null,
        $arrData = null, $toSm = false, $badge = 0, $arrPayload = null, $isLive = true)
    {
        $count = count($cids);
        if($count < 1 ) {
            return false;
        }

        $i      = 0;
        $result = true;
        $rt     = false;

        //群推给用户较少，采用单条推送
        if($count < 20) {
            $result = true;
            foreach($cids as $cid) {
                if($isLive) {
                    $rt = $this->pushMessageToSingle($cid, $strType,  $strTitle, $strContent, $arrData, $toSm, $badge, $arrPayload, 10 * 60);
                } else {
                    $rt = $this->pushMessageToSingle($cid, $strType, $strTitle, $strContent, $arrData, $toSm, $badge, $arrPayload);
                }
                $result = $result && $rt;
            }
            return $result;
        }

        while($i * self::item <= $count ) {
            $length = ($count - $i * self::item) < self::item ? ($count - $i * self::item) : self::item;
            $output = array_slice($cids, $i * self::item, $length, true);
            $i++;
            if($isLive) {
                $rt = $this->pushMessageToList($output, $strType, $strTitle, $strContent, $arrData, $toSm, $badge, $arrPayload, 10 * 60);
            } else {
                $rt = $this->pushMessageToList($output, $strType, $strTitle, $strContent, $arrData, $toSm, $badge, $arrPayload);
            }
            $result = $result && $rt;
        }

        return $result;
    }

    public function writeTaskIdToFile($task_id, $content, $type)
    {
        $flag = ArrayHelper::getValue(\Yii::$app->params,'live.live_notify_log', 0);

        if(!$flag) {
            return false;
        }
        $fileName = "live_notify_".date('Y-m-d').".log";
        $str = $type .' : ' . $task_id . ' : ' . json_encode($content);
        Tool::commandLog($fileName, $str);
    }

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
