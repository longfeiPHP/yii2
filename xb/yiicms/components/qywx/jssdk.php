<?php
namespace app\components\qywx;

class JSSDK {
  private $corpid;
  private $corpsecret;
  //define('APP_PATH', dirname( __FILE__ ).'/');
  //corpid=id&corpsecret=secrect

  public function __construct($corpid, $corpsecret) {
    $this->corpid = $corpid;
    $this->corpsecret = $corpsecret;
  }
  public function getAccessToken() {
    // access_token 应该全局存储与更新
    $filename =dirname( __FILE__ ).'/token/'.'access_token.json';
    $position = strrpos($filename,'/');  
    $path = substr($filename,0,$position);  
    if(!file_exists($path)){  
        mkdir($path,0777,true);  
    }
    if (!is_file($filename)) {
      $data['expire_time'] =0;
      $data['access_token'] =0;
    }else{
      $data = json_decode(file_get_contents($filename),true);
    }
    
    if ($data['expire_time'] < time() ) {
      // 如果是企业号用以下URL获取access_token
      $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->corpid&corpsecret=$this->corpsecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data['expire_time'] = time() + 7000;
        $data['access_token'] = $access_token;
        $fp = fopen($filename, "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $access_token = $data['access_token'] ;
    }

    return $access_token;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
}

