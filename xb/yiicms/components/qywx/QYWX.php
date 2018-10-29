<?php
  //日志记录
namespace app\components\qywx;
use app\components\qywx\jssdk;
use app\components\qywx\log;

class QYWX {

	public function sendText($to,$toType,$content)
	{
		$jssdk = new JSSDK("ww8f4c99aafaf06430", "SJATL49fJKg8494QvyWaM70FHFv2sfCS3Pd929pAT30");
		$access_token = $jssdk->getAccessToken();
		$url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$access_token";
		// $url="http://cms.mytest.com/site/send-wx-text.html";
		$contentarr=array('content' => $content );
		//$to 以|分割 如UserID1|UserID2|UserID3
		$Params = array(
	      'touser'  => "",
	      'totag'   => "",
	      'toparty'   => "",
	      'msgtype' => 'text',
	      'agentid' => '1000002',
	      'text'    => $contentarr,
	      'safe' => '0'
	    );
	    $typeArr=['user','tag','party'];
	    if (!in_array($toType,$typeArr)) {
	    	return ['result' =>false,'msg'=>'不存在的目标类型！'];
	    }
	    switch ($toType) {
	    	case 'user':
	    		$Params['touser']=$to;
	    		break;
	    	case 'tag':
	    		$Params['totag']=$to;
	    		break;
	    	case 'party':
	    		$Params['toparty']=$to;
	    		break;
	    	default:
	    		break;
	    }
	    $log = new log();
	    $log->writelog("send: ".var_export($Params,true),'qywx');
	    $EchoStr =  json_encode($Params, JSON_UNESCAPED_UNICODE);
		$rs= $this->makeRequest($url,$EchoStr);
		$log->writelog("rev: ".var_export($rs,true),'qywx');
		return $rs;
	}

	public function checkSign($key,$sign,$params)
	{
		if (empty($sign)) {
			return false;
		}
		if ($this->makeSign($key,$params) !== $sign)
        	return false;
        return true;
	}

	public function makeSign($key,$params)
	{
		$nowTime = time();

		if (empty($params['time'])) {
			return '';
		}else {
			$ptime = $params['time'];
		}
		if ($nowTime + 300 < $ptime  || $ptime < $nowTime - 300 )  {
			return '';
		}

		if (!is_array($params))
        	$params = array();
	    ksort($params);
	    $query_array = array();
	    foreach ($params as $k => $v) {
	        array_push($query_array, $k . '=' . $v);
	    }
	    $query_string = join('&', $query_array);
	    return strtoupper(sha1( $query_string . $key));
	}

	private function httpPost($url,$post_data){
	  $ch = curl_init () ;
	  echo $url;
	  curl_setopt ( $ch , CURLOPT_POST , 1 ) ;
	  curl_setopt ( $ch , CURLOPT_HEADER , 0 ) ;
	  curl_setopt ( $ch , CURLOPT_URL , $url ) ;
	  curl_setopt ( $ch , CURLOPT_POSTFIELDS , $post_data ) ;
	  curl_setopt (  $ch, CURLOPT_RETURNTRANSFER, true);
	  $result = curl_exec ( $ch ) ;
	  echo "result:".$result;
	  curl_close($ch);
	  return $result;
	}

	function makeRequest($url, $params,  $method='post', $protocol='http')
    {
        $query_string = $params;

        $ch = curl_init();

        if ('GET' == strtoupper($method))
        {
            curl_setopt($ch, CURLOPT_URL, "$url?$query_string");
        }
        else
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
        }

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        // disable 100-continue
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        if (!empty($cookie_string))
        {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie_string);
        }

        if ('https' == $protocol)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $ret = curl_exec($ch);
        $err = curl_error($ch);

        if (false === $ret || !empty($err))
        {
            $errno = curl_errno($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            return array(
                'result' => false,
                'errno' => $errno,
                'msg' => $err,
                'info' => $info,
            );
        }

        curl_close($ch);

        return array(
            'result' => true,
            'msg' => $ret,
        );

    }

}

?>