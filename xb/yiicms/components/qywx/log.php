<?php
  //日志记录
namespace app\components\qywx;
class log {

    public function writelog($log_content,$funcName)
    {
        $path =dirname(dirname(dirname(__FILE__))).'/log/'.$funcName;
        if (!is_dir($path)){  
            $res=mkdir(iconv("UTF-8", "GBK", $path),0777,true); 
        }
        
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);

        }else { 
            $max_size = 10000;
            $filedate=date("Y-m-d");
            $log_filename =  $path."/logfile".$filedate.".txt";
            // if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){
            //     unlink($log_filename);
            // }
            // elseif (!file_exists($log_filename)) {
            //     $filex=fopen($log_filename, r);
            //     fclose($filex);
            // }
            
            file_put_contents($log_filename, date('H:i:s')."\n ".$log_content."\r\n", FILE_APPEND);
        }
    }
}
?>