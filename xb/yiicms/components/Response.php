<?php
/**
 * User: Stanleylfc
 * Date: 15-6-8 下午7:20
 * Description:
 */
namespace app\components;

class Response{

      const JSON = 'json';
     // const JSON = 'array';
    /**
     * 通用接口方法
     * @param $code
     * @param string $message
     * @param array $data
     * @param string $type
     */

    public static function show($code , $message = '', $data = array(), $type = self::JSON ) {
        if(!is_numeric($code)) {
            return;
        }

        header("Content-type:application/json");
        $result = array(
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        );

        if($type == 'json') {
            self::json($code, $message, $data);
            exit;
        } else if($type == 'array') {
            var_dump($result);
            //print_r($result, true);
        } else if($type == 'xml'){
            self::xmlEncode($code, $message, $data);
            exit;
        }else {
            //TODO
        }
    }


    /**
     *
     * 按json方式返回
     * @param $code  返回代码
     * @param string $message 提示信息
     * @param array $data  数据
     * @return string|void
     */
    public static function json($code, $message = '', $data = array()) {
        if(!is_numeric($code)) {
            return;
        }

        $result = array (
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        );

        switch($code){
            case 200:
            case 201:
            case 204:
            case 400:
            case 401:
            case 402:
            case 403:
            case 404:
            case 500:
            case 510:
                http_response_code(200);
                break;
            default:
                http_response_code(400);
                break;
        }
        echo json_encode($result);
        // exit;
    }

    /**
     *
     * 按xml方式返回
     * 有三种方式转化为xml
     * @param $code
     * @param string $message
     * @param array $data
     */
    public static function xmlEncode($code, $message = '', $data = array()) {
        if(!is_numeric($code)) {
            return ;
        }

        $result = array(
            'code' => $code,
            'msg' => $message,
            'data'  => $data,
        );
        header("Content-Type:text/xml");
        $xml = "<?xml version='1.0' encoding='UTF_8'?>";
        $xml .= "<root>";

        $xml .= self::xmlToEncode($result);

        $xml .="</root>";
        echo $xml;
        // exit;
    }

    public static function xmlToEncode($data) {
        $xml = $attr = "";
        foreach($data as $key => $value) {
            //处理xml不识别数字节点
            if(is_numeric($key)) {
                $attr = " id='{$key}'";
                $key = "item";
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= is_array($value) ? self::xmlToEncode($value) : $value; //递推处理
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }
}
